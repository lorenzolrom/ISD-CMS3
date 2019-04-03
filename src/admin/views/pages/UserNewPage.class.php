<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 9:21 PM
 */


namespace admin\views\pages;


use admin\views\forms\UserForm;

class UserNewPage extends FormDocument
{
    /**
     * UserNewPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(new UserForm(), array('administrator'));

        $this->setVariable("tabTitle", "New User");
    }
}