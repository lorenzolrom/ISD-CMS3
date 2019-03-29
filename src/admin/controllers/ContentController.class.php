<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 5:57 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\ContentEditPage;
use admin\views\pages\ContentNewPage;
use database\ContentDatabaseHandler;
use database\ElementDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\PageParameterException;
use exceptions\ValidationException;
use models\Content;

class ContentController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws PageParameterException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case "new":
                return $this->newContent();
                break;
            case "edit":
                return $this->editContent();
                break;
            case "delete":
                $this->deleteContent();
                return "";
                break;
            default;
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws PageParameterException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    private function newContent(): string
    {
        if(!isset($_GET['element']))
            throw new PageParameterException(PageParameterException::MESSAGES[PageParameterException::PARAMETER_NOT_SUPPLIED], PageParameterException::PARAMETER_NOT_SUPPLIED);

        $element = ElementDatabaseHandler::selectById((int)$_GET['element']);

        $page = new ContentNewPage($element);

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                ContentDatabaseHandler::insert($_POST['name'], SessionValidationController::validateSession()->getId(), $element->getId(), $_POST['area'], $_POST['content'], (int)$_POST['weight']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "elements/view/{$element->getId()}?NOTICE=Content Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    private function editContent(): string
    {
        $id = array_shift($this->uriParts);
        $content = ContentDatabaseHandler::selectById((int)$id);

        $page = new ContentEditPage($content);

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                ContentDatabaseHandler::update($content->getId(), $_POST['name'], $content->getAuthor(), $content->getElement(), $_POST['area'], $_POST['content'], (int)$_POST['weight']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "elements/view/{$content->getElement()}?NOTICE=Content Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    private function validateForm():array
    {
        $errors = array();

        $fields = array();

        foreach(Content::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }

        try
        {
            Content::validateName($fields['name']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateArea($fields['area']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateWeight((int)$fields['weight']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateContent($fields['content']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }

    /**
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     */
    private function deleteContent()
    {
        $id = array_shift($this->uriParts);
        $content = ContentDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        ContentDatabaseHandler::delete($content->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "elements/view/{$content->getElement()}?NOTICE=Content Deleted");
        exit;
    }
}