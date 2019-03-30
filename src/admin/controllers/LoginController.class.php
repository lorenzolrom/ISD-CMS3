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
use exceptions\TokenNotFoundException;
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
        // Log user out?
        if($this->uriParts[0] == "logout")
        {
            // Check for cookie
            if(isset($_COOKIE[\CMSConfiguration::CMS_CONFIG['cookieName']]))
            {
                // locate token
                try
                {
                    $token = TokenDatabaseHandler::selectByToken($_COOKIE[\CMSConfiguration::CMS_CONFIG['cookieName']]);
                    $token->setExpired(1);
                }
                catch(TokenNotFoundException $e)
                {
                    // Do nothing, destroy token
                }
            }

            // Destroy cookie
            setcookie(\CMSConfiguration::CMS_CONFIG['cookieName'], "", time() - 3600, \CMSConfiguration::CMS_CONFIG['baseURI']);
            header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "login?NOTICE=Successfully Logged Out");
            exit;
        }

        $page = new LoginPage();

        if(isset($_POST['username']) AND isset($_POST['password']))
        {
            // Find user
            try
            {
                try
                {
                    $user = UserDatabaseHandler::selectByUsername($_POST['username']);

                    if($user->getDisabled())
                        throw new SecurityException(SecurityException::MESSAGE[SecurityException::USER_IS_DISABLED], SecurityException::USER_IS_DISABLED);

                    if(!$user->isCorrectPassword($_POST['password']))
                        throw new SecurityException(SecurityException::MESSAGE[SecurityException::PASSWORD_IS_WRONG], SecurityException::PASSWORD_IS_WRONG);

                    $token = TokenDatabaseHandler::create($user);

                    setcookie(\CMSConfiguration::CMS_CONFIG['cookieName'], $token->getToken(), 0, \CMSConfiguration::CMS_CONFIG['baseURI']);

                    $next = \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'];

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