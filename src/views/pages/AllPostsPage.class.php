<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 5:22 PM
 */


namespace views\pages;

use database\PostCategoryDatabaseHandler;
use database\PostDatabaseHandler;
use views\content\Post;
use views\content\PostCategory;

/**
 * Class AllPostsPage
 *
 * Page that lists all posts/categories
 *
 * @package views\pages
 */
class AllPostsPage extends HeaderFooterPage
{
    /**
     * AllPostsPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostCategoryNotFoundException
     */
    public function __construct()
    {
        parent::__construct();

        $this->setVariable("mainContent", self::templateFileContents("AllPostsPage", self::TEMPLATE_PAGE));

        $this->setVariable("tabTitle", "Posts");
        $this->setVariable("pageTitle", "Posts");

        // Build Post List

        $postList = "";

        foreach(PostDatabaseHandler::selectAll() as $post)
        {
            $view = new Post($post);
            $postList .= $view->getHTML();
        }

        $this->setVariable("postList", $postList);

        $categoryList = "";

        foreach(PostCategoryDatabaseHandler::selectAll() as $category)
        {
            $view = new PostCategory($category);
            $categoryList .= $view->getHTML();
        }

        $this->setVariable("categoryList", $categoryList);
    }
}