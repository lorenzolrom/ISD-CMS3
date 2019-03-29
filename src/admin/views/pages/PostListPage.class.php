<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 9:23 PM
 */


namespace admin\views\pages;


use admin\views\elements\PostListTable;

class PostListPage extends UserDocument
{
    /**
     * PostListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "Posts");
        $list = new PostListTable();
        $this->setVariable("mainContent", $list->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "New Post",
                'href' => "posts/new"
            ),
            array(
                'title' => "Manage Categories",
                'href' => "categories"
            )
        ));
    }
}