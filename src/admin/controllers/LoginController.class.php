<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 3:23 PM
 */


namespace admin\controllers;


use admin\views\pages\LoginPage;
use database\TokenDatabaseHandler;
use database\UserDatabaseHandler;
use exceptions\SecurityException;
use exceptions\UserNotFoundException;

class LoginController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\ViewException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\TokenNotFoundException
     */
    public function getPage(): string
    {
        $page = new LoginPage();

        if(isset($_POST['username']) AND isset($_POST['password']))
        {
            // Find user
            try
            {
                try
                {
                    $user = UserDatabaseHandler::selectByUsername($_POST['username']);

                    if(!$user->isCorrectPassword($_POST['password']))
                        throw new SecurityException(SecurityException::MESSAGE[SecurityException::PASSWORD_IS_WRONG], SecurityException::PASSWORD_IS_WRONG);

                    $token = TokenDatabaseHandler::create($user);

                    setcookie(\CMSConfiguration::CMS_CONFIG['cookieName'], $token->getToken(), 0, \CMSConfiguration::CMS_CONFIG['baseURI']);

                    $next = \CMSConfiguration::CMS_CONFIG['baseURI'] . "user";

                    if(isset($_GET['NEXT']))
                        $next = $_GET['NEXT'];

                    header("Location: $next");
                    exit;
                }
                catch (UserNotFoundException $e)
                {
                    throw new SecurityException(SecurityException::MESSAGE[SecurityException::USERNAME_NOT_FOUND], SecurityException::USERNAME_NOT_FOUND, $e);
                }
            }
            catch(SecurityException $e)
            {
                // Display error messages to view
                $page->setErrors(array($e->getMessage()));
            }

        }

        return $page->getHTML();
    }
}