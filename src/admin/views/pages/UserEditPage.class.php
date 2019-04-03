<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 10:19 PM
 */


namespace admin\views\pages;


use admin\views\forms\UserForm;
use models\User;

class UserEditPage extends FormDocument
{
    /**
     * UserEditPage constructor.
     * @param User $user
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(User $user)
    {
        parent::__construct(new UserForm($user), array('administrator'));

        $this->setVariable("tabTitle", "Edit User: " . $user->getUsername());
    }
}