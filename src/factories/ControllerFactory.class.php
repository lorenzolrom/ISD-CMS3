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
            case "admin":
                return new AdminController($uri);
                break;
            default:
                return new PageController($uri);
                break;
        }
    }
}