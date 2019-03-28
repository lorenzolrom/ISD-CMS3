<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:47 PM
 */


namespace views\elements;


use controllers\FrontController;
use database\PageDatabaseHandler;
use models\Page;
use views\View;

class Header extends View
{
    /**
     * Header constructor.
     * @param Page|null $currentPage Current page the user is on, for purpose of indicating current page on navigation
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?Page $currentPage = NULL)
    {
        $this->setTemplateFromHTML("Header", View::TEMPLATE_ELEMENT);

        // Generate navigation menu
        $navigationLinks = "";

        foreach(PageDatabaseHandler::select(TRUE) as $page)
        {
            // Check if page has navTitle
            $pageTitle = $page->getTitle();

            if($page->getNavTitle() !== NULL)
                $pageTitle = $page->getNavTitle();

            $pageURI = $page->getUri();

            // Is this page the current page?
            if($currentPage !== NULL AND $currentPage->getId() == $page->getId())
                $current = " class='current'";
            else
                $current = "";

            $navigationLinks .= "<li><a href='{{@baseURI}}$pageURI' $current>$pageTitle</a></li>";
        }

        // Add static navigation links
        $uri = FrontController::getURI();

        // Determine the current page is related to displaying posts
        $isPost = FALSE;

        $uriParts = explode('/', $uri);
        if(sizeof($uriParts) > 0)
        {
            if($uriParts[0] == "posts" OR $uriParts[0] == "category")
                $isPost = TRUE;
        }

        $navigationLinks .= "<li><a href='{{@baseURI}}posts'" . ($isPost ? " class='current'" : "") . ">Projects</a></li>";

        // Set final navigation menu
        $this->setVariable("navContent", $navigationLinks);

        // Set Header Greeting
        $hour = date("H");

        if($hour < "12")
            $headerGreeting = "Good morning; have a nice day.";
        else if($hour >= "12" AND $hour < "17")
            $headerGreeting = "Good afternoon; hope your day is going well.";
        else if($hour >= "17")
            $headerGreeting = "Good evening; hope you had a nice day.";
        else
            $headerGreeting = "Welcome to the site!";

        $this->setVariable("headerGreeting", $headerGreeting);
    }
}