<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 11:06 AM
 */


namespace views\content;


use database\PageDatabaseHandler;
use views\View;

class PageSearchResult extends View
{
    /**
     * PageSearchResult constructor.
     * @param string $uri
     * @param array $results
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(string $uri, array $results)
    {
        $this->setTemplateFromHTML("PageSearchResult", self::TEMPLATE_CONTENT);

        $page = PageDatabaseHandler::selectByUri($uri);

        $this->setVariable("pageTitle", $page->getTitle());
        $this->setVariable("pageURI", $page->getUri());

        $this->setVariable("resultCount", sizeof($results));
    }
}