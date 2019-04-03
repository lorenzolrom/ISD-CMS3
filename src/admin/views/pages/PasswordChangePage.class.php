<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 1:37 PM
 */


namespace admin\views\pages;


use admin\views\forms\PasswordChangeForm;
use models\User;

class PasswordChangePage extends FormDocument
{
    public function __construct(User $user)
    {
        parent::__construct(new PasswordChangeForm($user));

        $this->setVariable("tabTitle", "Change Password");
    }
}