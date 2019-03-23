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
        // Create string of URL requested by browser
        if(isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS' == 'on'])
            $requestedURL = "https";
        else
            $requestedURL = "http";

        $requestedURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // Produce final resource identifier
        $uri = strtolower(rtrim(explode(\CMSConfiguration::CMS_CONFIG['baseURL'] . \CMSConfiguration::CMS_CONFIG['baseURI'], $requestedURL)[1], "/"));

        // Locate controller for page
        try
        {
            try
            {
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
}