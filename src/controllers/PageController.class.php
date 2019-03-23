<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/12/2019
 * Time: 12:36 PM
 */


namespace controllers;

use database\PageDatabaseHandler;
use factories\ViewFactory;

/**
 * Class PageController
 * @package controllers
 */
class PageController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        $page = PageDatabaseHandler::selectByUri($this->uri);
        return ViewFactory::getPageView($page)->getHTML();
    }
}