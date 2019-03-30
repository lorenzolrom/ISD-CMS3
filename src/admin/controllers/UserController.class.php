<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 8:55 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\UserEditPage;
use admin\views\pages\UserListPage;
use admin\views\pages\UserNewPage;
use database\UserDatabaseHandler;
use exceptions\PageNotFoundException;
use exceptions\ValidationException;
use models\User;

class UserController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\RoleNotFoundException
     */
    public function getPage(): string
    {
        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new UserListPage();
                return $page->getHTML();
                break;
            case "new":
                return $this->createUser();
                break;
            case "edit":
                return $this->editUser();
                break;
            case "delete":
                $this->deleteUser();
                return "";
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\UserNotFoundException
     */
    private function createUser(): string
    {
        $page = new UserNewPage();

        if(!empty($_POST))
        {
            $errors = $this->validateForm();

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                $displayName = NULL;

                if(isset($_POST['displayName']) AND strlen($_POST['displayName']) > 0)
                    $displayName = $_POST['displayName'];

                UserDatabaseHandler::insert($_POST['username'], User::hashPassword($_POST['password']), $_POST['firstName'], $_POST['lastName'], $displayName, $_POST['email'], (int)$_POST['disabled'], $_POST['role']);
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "cpanel/users?NOTICE=User Created");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function editUser(): string
    {
        $id = array_shift($this->uriParts);
        $user = UserDatabaseHandler::selectById((int)$id);

        $page = new UserEditPage($user);

        if(!empty($_POST))
        {
            $errors = $this->validateForm($user);

            if(!empty($errors))
            {
                $page->setErrors($errors);
            }
            else
            {
                $displayName = NULL;

                if(isset($_POST['displayName']) AND strlen($_POST['displayName']) > 0)
                    $displayName = $_POST['displayName'];

                UserDatabaseHandler::update($user->getId(), $_POST['username'], $_POST['firstName'], $_POST['lastName'], $displayName, $_POST['email'], (int)$_POST['disabled'], $_POST['role']);

                if(isset($_POST['password']) AND strlen($_POST['password']) > 0)
                {
                    UserDatabaseHandler::updatePassword($user->getId(), User::hashPassword($_POST['password']));
                }

                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "cpanel/users?NOTICE=User Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function deleteUser()
    {
        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('administrator'));

        $id = array_shift($this->uriParts);
        $user = UserDatabaseHandler::selectById((int)$id);

        // Safeguard against self-deletion
        if(SessionValidationController::validateSession()->getId() == $user->getId())
        {
            header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "cpanel/users?NOTICE=Cannot Delete Current User");
            exit;
        }

        UserDatabaseHandler::delete($user->getId());
        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "cpanel/users?NOTICE=User Deleted");
        exit;
    }

    private function validateForm(?User $user = NULL): array
    {
        $errors = array();

        $fields = array();

        foreach(User::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $field)
        {
            $fields[$field] = $_POST[$field];
        }

        if($user !== NULL AND $user->getUsername() != $fields['username'])
        {
            try
            {
                User::validateUsername($fields['username']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            User::validateFirstName($fields['firstName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateLastName($fields['lastName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateDisplayName($fields['displayName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        if($user !== NULL AND $user->getEmail() != $fields['email'])
        {
            try
            {
                User::validateEmail($fields['email']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            User::validateDisabled((int)$fields['disabled']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateRole($fields['role']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        if($user !== NULL AND ($fields['password'] !== NULL AND strlen($fields['password']) > 0))
        {
            try
            {
                User::validatePassword($fields['password'], $fields['confirm']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }
}