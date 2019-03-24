<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 6:28 PM
 */


namespace views\pages;


use database\PostDatabaseHandler;
use models\PostCategory;
use views\content\Post;

class PostCategoryPage extends HeaderFooterPage
{
    /**
     * PostCategoryPage constructor.
     * @param PostCategory $category
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(PostCategory $category)
    {
        parent::__construct();

        $this->setVariable("mainContent", self::templateFileContents("PostCategoryPage", self::TEMPLATE_PAGE));

        $this->setVariable("tabTitle", $category->getTitle());
        $this->setVariable("categoryName", $category->getTitle());

        // Build Post List

        $postList = "";

        foreach(PostDatabaseHandler::selectByCategory($category->getId()) as $post)
        {
            $view = new Post($post);
            $postList .= $view->getHTML();
        }

        $this->setVariable("postList", $postList);
    }
}