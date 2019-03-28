<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 3:09 PM
 */


namespace admin\factories;


use admin\controllers\DashboardController;
use admin\controllers\DoorwaysController;
use admin\controllers\LoginController;
use controllers\Controller;
use exceptions\PageNotFoundException;

class ControllerFactory
{
    /**
     * @param array $uriParts
     * @return Controller
     * @throws PageNotFoundException
     */
    public static function getController(array $uriParts): Controller
    {
        // If user goes to base admin page
        if(empty($uriParts))
            $uriParts[] = "";

        switch($uriParts[0])
        {
            case "":
                return new DashboardController($uriParts);
                break;
            case "logout":
            case "login":
                return new LoginController($uriParts);
                break;
            case "doorways":
                return new DoorwaysController($uriParts);
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
                break;
        }
    }
}