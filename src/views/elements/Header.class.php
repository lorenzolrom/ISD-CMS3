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

        foreach(PageDatabaseHandler::selectAll(TRUE) as $page)
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

        $navigationLinks .= "<li><a href='{{@baseURI}}posts'>Projects</a></li>";

        $this->setVariable("navContent", $navigationLinks);
    }
}