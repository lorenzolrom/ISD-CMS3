<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 4:58 PM
 */


namespace admin\controllers;


use admin\views\pages\CPanelHomePage;
use exceptions\PageNotFoundException;

class CPanelController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\RoleNotFoundException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new CPanelHomePage();
                return $page->getHTML();
                break;
            case "users":
                $controller = new UserController($this->uriParts);
                return $controller->getPage();
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }


}