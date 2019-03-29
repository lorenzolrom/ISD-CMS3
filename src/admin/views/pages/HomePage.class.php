<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 7:13 AM
 */


namespace admin\views\pages;


class HomePage extends UserDocument
{
    public function __construct()
    {
        parent::__construct();
        $this->setVariable("tabTitle", "Home");
        $this->setActionLinks(array(
            array(
                'title' => "Change Password",
                'href' => 'account/changepassword'
            )
        ));
    }
}