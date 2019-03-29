<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:02 PM
 */


namespace admin\views\elements;


use database\PostCategoryDatabaseHandler;

class PostCategoryListTable extends ListTable
{
    /**
     * PostCategoryListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $rows = array();

        foreach(PostCategoryDatabaseHandler::selectAll(FALSE) as $category)
        {
            $rows[] = array(
                'id' => $category->getId(),
                'cells' => array(
                    'title' => $category->getTitle(),
                    'displayed' => ($category->getDisplayed() ? "✓" : "")
                )
            );
        }

        parent::__construct("categories", $rows);
        $this->setHeader(array('Title', 'Displayed'));
    }
}