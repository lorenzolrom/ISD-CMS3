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

use database\DoorwayDatabaseHandler;
use database\PageDatabaseHandler;
use exceptions\DatabaseException;
use exceptions\DoorwayNotFoundException;
use exceptions\PageNotFoundException;
use factories\ViewFactory;
use views\pages\PageNotFoundPage;

/**
 * Class PageController
 * @package controllers
 */
class PageController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ContentNotFoundException
     * @throws PageNotFoundException
     */
    public function getPage(): string
    {
        try
        {
            try
            {
                $page = PageDatabaseHandler::selectByUri($this->uri);
                return ViewFactory::getPageView($page)->getHTML();
            }
            catch(PageNotFoundException $e)
            {
                // Attempt to locate a doorway
                try
                {
                    $doorway = DoorwayDatabaseHandler::selectByUri($this->uri);
                    header("Location: " . $doorway->getDestination());
                    exit;
                }
                catch (DoorwayNotFoundException $de)
                {
                    throw $e;
                }
            }
        }
        catch(PageNotFoundException $e)
        {
            // Create new page not found page
            $page = new PageNotFoundPage($e);
            return $page->getHTML();
        }
    }
}