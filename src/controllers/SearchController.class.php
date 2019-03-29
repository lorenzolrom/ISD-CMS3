<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:40 AM
 */


namespace controllers;

use database\ContentDatabaseHandler;
use database\PostDatabaseHandler;
use exceptions\SearchException;
use models\SearchResult;
use views\pages\SearchPage;

/**
 * Class SearchController
 *
 * Search the website
 *
 * @package controllers
 */
class SearchController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     */
    public function getPage(): string
    {
        try
        {
            // Verify search query is given
            if(!isset($_GET['query']) OR strlen($_GET['query']) < 1)
                throw new SearchException(SearchException::MESSAGES[SearchException::QUERY_NOT_SUPPLIED], SearchException::QUERY_NOT_SUPPLIED);

            $query = $_GET['query'];

            // Strip HTML tags
            $query = strip_tags($query);

            // Verify query length
            if(strlen($query) < 3)
                throw new SearchException(SearchException::MESSAGES[SearchException::QUERY_TOO_SHORT], SearchException::QUERY_TOO_SHORT);

            // Get content/posts with matching strings from database
            $contents = ContentDatabaseHandler::selectByContent($query);
            $posts = PostDatabaseHandler::selectByContent($query);

            $results = array(
                'query' => $query,
                'posts' => array(),
                'pages' => array()
            );

            foreach($posts as $post)
            {
                $results['posts'][] = $post;
            }

            foreach($contents as $content)
            {
                // Make sure query is not matching an html tag
                if(!strpos(strip_tags(strtolower($content->getContent())), strtolower($query)))
                {
                    continue;
                }

                $page = $content->getElementObject()->getPageObject();
                $results['pages'][$page->getUri()][] = $content;
            }

            // Render search page
            $page = new SearchPage(new SearchResult($results));
            return $page->getHTML();
        }
        catch(SearchException $e)
        {
            $page = new SearchPage(NULL, $e);
            return $page->getHTML();
        }
    }
}