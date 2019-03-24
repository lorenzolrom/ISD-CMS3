<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:45 AM
 */


namespace views\pages;

use exceptions\SearchException;
use models\SearchResult;
use views\elements\PageSearchResultList;
use views\elements\PostSearchResultList;

class SearchPage extends HeaderFooterPage
{
    /**
     * SearchPage constructor.
     * @param SearchResult $result
     * @param SearchException|null $e
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?SearchResult $result = NULL, ?SearchException $e = NULL)
    {
        parent::__construct();
        $this->setVariable("tabTitle", "Search");

        if($e !== NULL)
        {
            $this->setVariable("mainContent", self::templateFileContents("BasicPage", self::TEMPLATE_PAGE));
            $this->setVariable("pageTitle", "Search");
            $this->setVariable("mainContent", "<p>Could not complete search: {$e->getMessage()}</p>");
        }
        else
        {
            $this->setVariable("mainContent", self::templateFileContents("SearchPage", self::TEMPLATE_PAGE));
            $this->setVariable("query", $result->getQuery());
            $this->setVariable("searchCount", $result->getResultCount());

            $searchResults = "";

            if(!empty($result->getPostResults()))
            {
                $postResults = new PostSearchResultList($result->getPostResults());
                $searchResults .= $postResults->getHTML();
            }

            if(!empty($result->getPageResults()))
            {
                $pageResults = new PageSearchResultList($result->getPageResults());
                $searchResults .= $pageResults->getHTML();
            }


            $this->setVariable("searchResults", $searchResults);
        }
    }
}