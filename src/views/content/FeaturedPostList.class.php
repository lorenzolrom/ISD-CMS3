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

class FeaturedPostList extends Content
{
    /**
     * FeaturedPosts constructor.
     * @param \models\Content $content
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);
        $this->setTemplateFromHTML("FeaturedPostList", self::TEMPLATE_CONTENT);

        // Get number of featured posts to display
        $listAttributes = json_decode($content->getContent(), TRUE);
        $count = $listAttributes['count'];

        // Create list

        $postList = "";

        foreach(PostDatabaseHandler::selectByFeatured(intval($count)) as $post)
        {
            $view = new Post($post);
            $postList .= $view->getHTML();
        }

        $this->setVariable("postList", $postList);
    }
}