<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 8:17 PM
 */


namespace views\content;


use database\PostDatabaseHandler;
use exceptions\PostNotFoundException;
use views\View;

class FeaturedPostList extends View
{
    /**
     * FeaturedPosts constructor.
     * @param int $count
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(int $count)
    {
        $this->setTemplateFromHTML("FeaturedPostList", self::TEMPLATE_CONTENT);

        // Get number of featured posts to display

        // Create list

        $postList = "";

        try
        {
            foreach (PostDatabaseHandler::selectByFeatured((int)$count) as $post) {
                $view = new Post($post);
                $postList .= $view->getHTML();
            }
        }
        catch(PostNotFoundException $e)
        {
            // Ignore
        }

        $this->setVariable("postList", $postList);
    }
}