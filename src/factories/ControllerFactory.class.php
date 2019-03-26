<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/12/2019
 * Time: 12:18 PM
 */


namespace factories;


use controllers\AdminController;
use controllers\Controller;
use controllers\PageController;
use controllers\PostController;
use controllers\SearchController;

/**
 * Class ControllerFactory
 * @package factories
 */
class ControllerFactory
{
    /**
     * Retrieve appropriate controller based on requested URI
     * This will check for statically set routes (e.g. admin), if none is found uri is referred to PageController
     * @param string $uri
     * @return Controller
     */
    public static function getController(string $uri): Controller
    {
        // Determine the first part of the URI
        $uriFirst = explode('/', $uri)[0];

        switch($uriFirst)
        {
            case rtrim(\CMSConfiguration::CMS_CONFIG['adminURI'], '/'):
                return new AdminController($uri);
                break;
            case "posts":
                return new PostController($uri);
                break;
            case "category":
                return new PostController($uri);
                break;
            case "search":
                return new SearchController($uri);
                break;
            default:
                return new PageController($uri);
                break;
        }
    }
}