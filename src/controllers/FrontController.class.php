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
        // Locate controller for page
        try
        {
            try
            {
                $uri = self::getURI();

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
        // Remove the baseURI and convert to lowercase
        $reqURI = explode(\CMSConfiguration::CMS_CONFIG['baseURI'], strtolower($_SERVER['REQUEST_URI']))[1];

        // Remove Query Params
        $reqURI = explode('?', $reqURI)[0];

        // Remove trailing slash
        $reqURI = rtrim($reqURI, '/');

        return $reqURI;
    }
}