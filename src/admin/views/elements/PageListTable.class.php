<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 9:28 PM
 */


namespace admin\views\elements;


use database\PageDatabaseHandler;

class PageListTable extends ListTable
{
    /**
     * PageListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $rows = array();

        foreach(PageDatabaseHandler::select() as $page)
        {
            $rows[] = array(
                'id' => $page->getId(),
                'cells' => array(
                    'title' => $page->getTitle(),
                    'uri' => $page->getUri(),
                    'type' => $page->getType(),
                    'weight' => $page->getWeight()
                )
            );
        }

        parent::__construct("pages", $rows, TRUE);
        $this->setHeader(array('Title', 'URI', 'Type', 'Weight'));
    }
}