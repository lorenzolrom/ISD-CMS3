<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:12 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\PostCategoryEditPage;
use admin\views\pages\PostCategoryListPage;
use admin\views\pages\PostCategoryNewPage;
use database\PostCategoryDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\ValidationException;
use models\PostCategory;

class PostCategoryController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new PostCategoryListPage();
                return $page->getHTML();
                break;
            case "new":
                return $this->newCategory();
                break;
            case "edit":
                return $this->editCategory();
                break;
            case "delete":
                $this->deleteCategory();
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
     */
    private function newCategory(): string
    {
        $page = new PostCategoryNewPage();

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                PostCategoryDatabaseHandler::insert($_POST['title'], $_POST['previewImage'], (int)$_POST['displayed']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "categories?NOTICE=Category Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function editCategory(): string
    {
        $id = array_shift($this->uriParts);
        $category = PostCategoryDatabaseHandler::selectById((int)$id);

        $page = new PostCategoryEditPage($category);

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                PostCategoryDatabaseHandler::update($category->getId(), $_POST['title'], $_POST['previewImage'], (int)$_POST['displayed']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "categories?NOTICE=Category Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function deleteCategory()
    {
        $id = array_shift($this->uriParts);
        $category = PostCategoryDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('author', 'editor', 'administrator'));

        PostCategoryDatabaseHandler::delete($category->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "categories?NOTICE=Category Deleted");
        exit;
    }

    /**
     * @return array
     */
    private function validateForm(): array
    {
        $errors = array();

        $fields = array();

        foreach(PostCategory::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $field)
        {
            $fields[$field] = $_POST[$field];
        }

        try
        {
            PostCategory::validateTitle($fields['title']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            PostCategory::validatePreviewImage($fields['previewImage']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            PostCategory::validateDisplayed((int)$fields['displayed']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}