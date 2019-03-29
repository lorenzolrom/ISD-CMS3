<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 1:29 PM
 */


namespace admin\controllers;

use admin\views\pages\AuthenticatedPage;
use admin\views\pages\DoorwayEditPage;
use admin\views\pages\DoorwayListPage;
use admin\views\pages\DoorwayNewPage;
use database\DoorwayDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\ValidationException;
use models\Doorway;

class DoorwaysController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new DoorwayListPage();
                return $page->getHTML();
                break;
            case "new":
                return $this->getNewPage();
                break;
            case "edit":
                return $this->getEditPage();
                break;
            case "delete":
                $this->deleteDoorway();
                return "";
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function getNewPage(): string
    {
        $page = new DoorwayNewPage();

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                DoorwayDatabaseHandler::insert($_POST['uri'], $_POST['destination'], (int)$_POST['enabled']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "doorways?NOTICE=Doorway Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function getEditPage(): string
    {
        $id = array_shift($this->uriParts);
        $doorway = DoorwayDatabaseHandler::selectById((int)$id);
        $page = new DoorwayEditPage($doorway);

        if(!empty($_POST))
        {
            $errors = $this->validateForm($doorway);

            if(!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                DoorwayDatabaseHandler::update($doorway->getId(), $_POST['uri'], $_POST['destination'], (int)$_POST['enabled']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "doorways?NOTICE=Doorway Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function deleteDoorway()
    {
        $id = array_shift($this->uriParts);
        $doorway = DoorwayDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        DoorwayDatabaseHandler::delete($doorway->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "doorways?NOTICE=Doorway Deleted");
        exit;
    }

    /**
     * @param Doorway|null $doorway Doorway to use for validation (to check for existing URI)
     * @return array Error messages (or empty if none)
     */
    private function validateForm(?Doorway $doorway = NULL): array
    {
        $errors = array();

        $uri = NULL;
        $destination = NULL;
        $enabled = NULL;

        if(isset($_POST['uri']))
            $uri = $_POST['uri'];

        if(isset($_POST['destination']))
            $destination = $_POST['destination'];

        if(isset($_POST['enabled']))
            $enabled = (int)$_POST['enabled'];

        // If we are editing a doorway and the URI has not changed do not validate it
        if($doorway === NULL OR $doorway->getUri() != $uri)
        {
            try
            {
                Doorway::validateURI($uri);
            }
            catch (ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            Doorway::validateDestination($destination);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Doorway::validateEnabled($enabled);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}