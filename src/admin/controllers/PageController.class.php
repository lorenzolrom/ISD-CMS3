<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 9:21 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\PageEditPage;
use admin\views\pages\PageListPage;
use admin\views\pages\PageNewPage;
use admin\views\pages\PageViewPage;
use database\PageDatabaseHandler;
use exceptions\PageNotFoundException;

class PageController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ElementNotFoundException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new PageListPage();
                return $page->getHTML();
                break;
            case "new":
                return $this->getNewPage();
                break;
            case "delete":
                $this->deletePage();
                return "";
                break;
            case "view":
                return $this->viewPage();
                break;
            case "edit":
                return $this->getEditPage();
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     */
    private function viewPage(): string
    {
        $id = array_shift($this->uriParts);
        $page = PageDatabaseHandler::selectById((int)$id);
        $view = new PageViewPage($page);
        return $view->getHTML();
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function getNewPage(): string
    {
        $page = new PageNewPage();

        if(!empty($_POST))
        {
            $errors = $page->getFormErrors();

            if (!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                $newPage = PageDatabaseHandler::insert($_POST['type'], SessionValidationController::validateSession()->getId(), trim(rtrim($_POST['uri'], '/')), $_POST['title'], $_POST['navTitle'], $_POST['previewImage'], (int)$_POST['isOnNav'], (int)$_POST['weight'], (int)$_POST['protected']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages/view/{$newPage->getId()}?NOTICE=Page Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function getEditPage(): string
    {
        $id = array_shift($this->uriParts);
        $page = PageDatabaseHandler::selectById((int)$id);
        $editPage = new PageEditPage($page);

        if(!empty($_POST))
        {
            $errors = $editPage->getFormErrors();

            if(!empty($errors))
                $editPage->setErrors($errors);
            else
            {
                PageDatabaseHandler::update($page->getId(), $_POST['type'], trim(rtrim($_POST['uri'], '/')), $_POST['title'], $_POST['navTitle'], $_POST['previewImage'], (int)$_POST['isOnNav'], (int)$_POST['weight'], (int)$_POST['protected']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages/view/{$page->getId()}?NOTICE=Page Updated");
                exit;
            }
        }

        return $editPage->getHTML();
    }

    /**
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     */
    private function deletePage()
    {
        $id = array_shift($this->uriParts);
        $page = PageDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        PageDatabaseHandler::delete($page->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages?NOTICE=Page Deleted");
        exit;
    }
}