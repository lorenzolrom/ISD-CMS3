<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 9:27 PM
 */


namespace admin\views\pages;


use admin\views\elements\PageListTable;

class PageListPage extends UserDocument
{
    /**
     * PageListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('editor','administrator'));

        $this->setVariable("tabTitle", 'Pages');

        $list = new PageListTable();
        $this->setVariable("mainContent", $list->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "New Page",
                'href' => "pages/new"
            )
        ));
    }
}