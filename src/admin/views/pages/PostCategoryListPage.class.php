<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:10 PM
 */


namespace admin\views\pages;


use admin\views\elements\PostCategoryListTable;

class PostCategoryListPage extends UserDocument
{
    /**
     * PostCategoryListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "Categories");

        $list = new PostCategoryListTable();
        $this->setVariable("mainContent", $list->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "New Category",
                'href' => "categories/new"
            )
        ));
    }
}