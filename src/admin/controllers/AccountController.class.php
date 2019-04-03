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

        $page = new PasswordChangePage($user);

        if(!empty($_POST))
        {
            $errors = $page->getFormErrors();

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

}