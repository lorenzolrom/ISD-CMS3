<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 7:47 PM
 */


namespace admin\controllers;


use database\TokenDatabaseHandler;
use database\UserDatabaseHandler;
use exceptions\SecurityException;
use exceptions\TokenNotFoundException;
use models\User;

class SessionValidationController
{
    public static function validateSession(): User
    {
        // Is cookie set?  If not direct to login
        if(!isset($_COOKIE[\CMSConfiguration::CMS_CONFIG['cookieName']]))
        {
            header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . "user/login");
            exit;
        }

        // Verify token
        try
        {
            try
            {
                $token = TokenDatabaseHandler::selectByToken($_COOKIE[\CMSConfiguration::CMS_CONFIG['cookieName']]);
                $token->isValid();

                return UserDatabaseHandler::selectById($token->getUser());
            }
            catch(TokenNotFoundException $e)
            {
                throw new SecurityException(SecurityException::MESSAGE[SecurityException::TOKEN_NOT_VALID], SecurityException::TOKEN_NOT_VALID);
            }
            catch(\Exception $e)
            {
                throw new SecurityException(SecurityException::MESSAGE[SecurityException::TOKEN_NOT_VALID], SecurityException::TOKEN_NOT_VALID);
            }
        }
        catch(SecurityException $e)
        {
            setcookie(\CMSConfiguration::CMS_CONFIG['cookieName'], "", time() - 3600, \CMSConfiguration::CMS_CONFIG['baseURI']);
            header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . "user/login?NOTICE={$e->getMessage()}&NEXT=" . explode('?', $_SERVER['REQUEST_URI'])[0]);
            exit;
        }
    }
}