<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 9:12 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\PostEditPage;
use admin\views\pages\PostListPage;
use admin\views\pages\PostNewPage;
use database\PostDatabaseHandler;
use exceptions\PageNotFoundException;

class PostController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostNotFoundException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new PostListPage();
                return $page->getHTML();
                break;
            case "new":
                return $this->newPost();
                break;
            case "edit":
                return $this->editPost();
                break;
            case "delete":
                $this->deletePost();
                return "";
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostNotFoundException
     */
    private function newPost(): string
    {
        $page = new PostNewPage();

        if(!empty($_POST))
        {
            $errors = $page->getFormErrors();

            if(!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                if($_POST['category'] == "")
                    $_POST['category'] = NULL;

                PostDatabaseHandler::insert($_POST['category'], SessionValidationController::validateSession()->getId(), $_POST['date'], $_POST['title'], $_POST['content'], $_POST['previewImage'], (int)$_POST['displayed'], (int)$_POST['featured']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "posts?NOTICE=Post Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function editPost(): string
    {
        $id = array_shift($this->uriParts);
        $post = PostDatabaseHandler::selectById((int)$id);

        $page = new PostEditPage($post);

        if(!empty($_POST))
        {
            $errors = $page->getFormErrors();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                if($_POST['category'] == "")
                    $_POST['category'] = NULL;

                PostDatabaseHandler::update($post->getId(), $_POST['category'], $post->getAuthor(), $_POST['date'], $_POST['title'], $_POST['content'], $_POST['previewImage'], (int)$_POST['displayed'], (int)$_POST['featured']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "posts?NOTICE=Post Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function deletePost()
    {
        $id = array_shift($this->uriParts);
        $post = PostDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('author', 'editor', 'administrator'));

        PostDatabaseHandler::delete($post->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "posts?NOTICE=Post Deleted");
        exit;
    }
}