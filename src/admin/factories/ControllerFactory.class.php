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


use admin\controllers\AccountController;
use admin\controllers\ContactFormSubmissionController;
use admin\controllers\CPanelController;
use admin\controllers\FileController;
use admin\controllers\PostCategoryController;
use admin\controllers\ContentController;
use admin\controllers\DashboardController;
use admin\controllers\DoorwayController;
use admin\controllers\ElementController;
use admin\controllers\LoginController;
use admin\controllers\PageController;
use admin\controllers\PostController;
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
            case "pages":
                return new PageController($uriParts);
                break;
            case "content":
                return new ContentController($uriParts);
                break;
            case "elements":
                return new ElementController($uriParts);
                break;
            case "doorways":
                return new DoorwayController($uriParts);
                break;
            case "posts":
                return new PostController($uriParts);
                break;
            case "categories":
                return new PostCategoryController($uriParts);
                break;
            case "files":
                return new FileController($uriParts);
                break;
            case "account":
                return new AccountController($uriParts);
                break;
            case "cpanel":
                return new CPanelController($uriParts);
                break;
            case "contacts":
                return new ContactFormSubmissionController($uriParts);
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
                break;
        }
    }
}