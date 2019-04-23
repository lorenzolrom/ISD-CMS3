<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/9/2019
 * Time: 2:40 PM
 */


namespace controllers;

use database\PageViewDatabaseHandler;
use factories\ControllerFactory;
use views\pages\FatalErrorPage;

/**
 * Class FrontController
 * @package controllers
 */
class FrontController
{
    /**
     * Interprets U.R.I. and constructs the page
     */
    public static function getPage(): string
    {
        // Locate controller for page
        try
        {
            try
            {
                $uri = self::getURI();

                // Log this page visit if it is enabled
                if(\CMSConfiguration::CMS_CONFIG['enableLogging'] === TRUE)
                {
                    PageViewDatabaseHandler::insert($uri, $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'));
                }

                $controller = ControllerFactory::getController($uri);
                return $controller->getPage();
            }
            catch(\Exception $e)
            {
                $page = new FatalErrorPage($e);
                return $page->getHTML();
            }
        }
        catch(\Exception $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public static function getURI(): string
    {
        // Create string of URL requested by browser
        if(isset($_SERVER['HTTPS']))
            $requestedURL = "https";
        else
            $requestedURL = "http";

        $requestedURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // Produce final resource identifier
        $uri = strtolower(rtrim(explode(\CMSConfiguration::CMS_CONFIG['baseURL'] . \CMSConfiguration::CMS_CONFIG['baseURI'], explode('?', $requestedURL)[0])[1], "/"));

        return $uri;
    }
}