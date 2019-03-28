<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 1:35 PM
 */


namespace admin\views\pages;


use admin\views\elements\DoorwayListTable;

class DoorwayListPage extends UserDocument
{
    /**
     * DoorwayListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Doorways");

        $list = new DoorwayListTable("doorways");
        $this->setVariable("mainContent", $list->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "New Doorway",
                'href' => 'doorways/new'
            )
        ));
    }
}