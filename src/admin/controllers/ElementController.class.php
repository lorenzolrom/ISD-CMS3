<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:33 AM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\ElementEditPage;
use admin\views\pages\ElementNewPage;
use admin\views\pages\ElementViewPage;
use database\ElementDatabaseHandler;
use database\PageDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\PageParameterException;
use exceptions\ValidationException;
use models\Element;

class ElementController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ContentNotFoundException
     * @throws PageParameterException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case "view":
                return $this->viewElement();
                break;
            case "new":
                return $this->newElement();
                break;
            case "edit":
                return $this->editElement();
                break;
            case "delete":
                $this->deleteElement();
                return "";
            default;
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function deleteElement()
    {
        $id = array_shift($this->uriParts);
        $element = ElementDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        ElementDatabaseHandler::delete($element->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "pages/view/{$element->getPage()}?NOTICE=Element Deleted");
        exit;
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ContentNotFoundException
     */
    private function viewElement(): string
    {
        $id = array_shift($this->uriParts);
        $element = ElementDatabaseHandler::selectById((int)$id);

        $view = new ElementViewPage($element);
        return $view->getHTML();
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws PageParameterException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     */
    private function newElement(): string
    {
        if(!isset($_GET['page']))
        {
            throw new PageParameterException(PageParameterException::MESSAGES[PageParameterException::PARAMETER_NOT_SUPPLIED], PageParameterException::PARAMETER_NOT_SUPPLIED);
        }

        $page = PageDatabaseHandler::selectById((int)$_GET['page']);

        $view = new ElementNewPage($page);

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
            {
                $view->setErrors($errors);
            }
            else
            {
                $element = ElementDatabaseHandler::insert($_POST['name'], $_POST['type'], $page->getId(), (int)$_POST['weight']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "elements/view/{$element->getId()}?NOTICE=Element Created");
                exit;
            }
        }

        return $view->getHTML();
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function editElement(): string
    {
        $id = array_shift($this->uriParts);
        $element = ElementDatabaseHandler::selectById((int)$id);

        $page = new ElementEditPage($element);

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                ElementDatabaseHandler::update($element->getId(), $_POST['name'], $_POST['type'], (int)$_POST['weight']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "elements/view/{$element->getId()}?NOTICE=Element Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    private function validateForm(): array
    {
        $errors = array();

        $fields = array();

        foreach(Element::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }

        // Name
        try
        {
            Element::validateName($fields['name']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Type
        try
        {
            Element::validateType($fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Weight
        try
        {
            Element::validateWeight((int)$fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}