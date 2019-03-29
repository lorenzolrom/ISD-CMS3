<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 1:35 PM
 */


namespace admin\controllers;


use admin\views\pages\PasswordChangePage;
use database\UserDatabaseHandler;
use exceptions\PageNotFoundException;
use models\User;

class AccountController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case "changepassword":
                return $this->changePassword();
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    private function changePassword(): string
    {
        $user = SessionValidationController::validateSession();

        $page = new PasswordChangePage();

        if(!empty($_POST))
        {
            $errors = $this->validateForm($user);

            if(!empty($errors))
                $page->setErrors($errors);
            else
            {
                UserDatabaseHandler::updatePassword($user->getId(), User::hashPassword($_POST['new']));
                header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "?NOTICE=Password Updated");
                exit;
            }
        }

        return $page->getHTML();
    }

    private function validateForm(User $user): array
    {
        $errors = array();

        if(!isset($_POST['current']) OR strlen($_POST['current']) < 1)
        {
            $errors[] = "Current Password Required";
        }
        else if(!$user->isCorrectPassword($_POST['current']))
        {
            $errors[] = "Current Password Is Incorrect";
        }
        else if(!isset($_POST['new']) OR strlen($_POST['new']) < 1)
        {
            $errors[] = "New Password Required";
        }
        else if(!isset($_POST['confirm']) OR $_POST['new'] != $_POST['confirm'])
        {
            $errors[] = "New Passwords Do Not Match";
        }

        return $errors;
    }
}