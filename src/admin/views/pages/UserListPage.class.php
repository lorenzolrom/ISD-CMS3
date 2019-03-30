<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 8:54 PM
 */


namespace admin\views\pages;


use admin\views\elements\UserListTable;

class UserListPage extends UserDocument
{
    /**
     * UserListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('administrator'));

        $list = new UserListTable();
        $this->setVariable("mainContent", $list->getHTML());

        $this->setVariable("tabTitle", "Users");

        $this->setActionLinks(array(
            array(
                'title' => "New User",
                'href' => "cpanel/users/new"
            )
        ));
    }
}