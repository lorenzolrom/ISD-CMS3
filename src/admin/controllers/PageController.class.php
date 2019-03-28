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
use database\PageDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\ValidationException;
use models\Page;

class PageController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
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
     * @throws \exceptions\ViewException
     */
    private function getNewPage(): string
    {
        $page = new PageNewPage();

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if (!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                PageDatabaseHandler::insert($_POST['type'], SessionValidationController::validateSession()->getId(), trim(rtrim($_POST['uri'], '/')), $_POST['title'], $_POST['navTitle'], intval($_POST['isOnNav']), intval($_POST['weight']));
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages?NOTICE=Page Created");
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
        $page = PageDatabaseHandler::selectById(intval($id));
        $editPage = new PageEditPage($page);

        if(!empty($_POST))
        {
            $errors = $this->validateForm($page);

            if(!empty($errors))
                $editPage->setErrors($errors);
            else
            {
                PageDatabaseHandler::update($page->getId(), $_POST['type'], trim(rtrim($_POST['uri'], '/')), $_POST['title'], $_POST['navTitle'], intval($_POST['isOnNav']), intval($_POST['weight']));
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages?NOTICE=Page Updated");
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
        $page = PageDatabaseHandler::selectById(intval($id));

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        PageDatabaseHandler::delete($page->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages?NOTICE=Page Deleted");
        exit;
    }

    /**
     * @param Page|null $page
     * @return array
     */
    private function validateForm(?Page $page = NULL): array
    {
        $errors = array();

        $fields = array();

        foreach(Page::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }


        // URI
        if($page === NULL OR $page->getUri() != $fields['uri'])
        {
            try
            {
                Page::validateURI($fields['uri']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        // Title
        try
        {
            Page::validateTitle($fields['title']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // ?NavTitle
        try
        {
            Page::validateNavTitle($fields['navTitle']);

            if(isset($_POST['navTitle']) AND strlen($_POST['navTitle']) == 0)
                $_POST['navTitle'] = NULL;
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // TYPE
        try
        {
            Page::validateType($fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Is On Nav
        try
        {
            Page::validateIsOnNav(intval($fields['isOnNav']));
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Weight
        try
        {
            Page::validateWeight(intval($fields['weight']));
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}