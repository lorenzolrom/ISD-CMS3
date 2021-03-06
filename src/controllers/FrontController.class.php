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
        // Remove baseURI
        $pos = strpos($_SERVER['REQUEST_URI'], \CMSConfiguration::CMS_CONFIG['baseURI']);
        $reqURI = substr_replace($_SERVER['REQUEST_URI'], '', $pos, strlen(\CMSConfiguration::CMS_CONFIG['baseURI']));

        // Remove Query Params and convert to lowercase
        $reqURI = strtolower(explode('?', $reqURI)[0]);

        // Remove trailing slash
        $reqURI = rtrim($reqURI, '/');

        return $reqURI;
    }
}