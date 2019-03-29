<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 9:29 PM
 */


namespace admin\views\elements;


use database\PostDatabaseHandler;

class PostListTable extends ListTable
{
    /**
     * PostListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostCategoryNotFoundException
     */
    public function __construct()
    {
        $rows = array();

        foreach(PostDatabaseHandler::selectAll(FALSE) as $post)
        {
            $category = $post->getCategoryObject();
            $rows[] = array(
                'id' => $post->getId(),
                'cells' => array(
                    'title' => $post->getTitle(),
                    'date' => $post->getDate(),
                    'category' => ($category === NULL ? "" : $category->getTitle()),
                    'displayed' => ($post->getDisplayed() ? "✓" : ""),
                    'featured' => ($post->getFeatured() ? "✓" : "")
                )
            );
        }

        parent::__construct("posts", $rows);
        $this->setHeader(array('Title', 'Date', 'Category', 'Displayed', 'Featured'));
    }
}