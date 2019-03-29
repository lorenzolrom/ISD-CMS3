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

class PasswordChangePage extends UserDocument
{
    public function __construct()
    {
        parent::__construct();

        $this->setVariable("tabTitle", "Change Password");

        $form = new PasswordChangeForm();
        $this->setVariable("mainContent", $form->getHTML());
    }
}