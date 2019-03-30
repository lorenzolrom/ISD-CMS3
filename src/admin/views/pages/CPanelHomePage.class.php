<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 4:57 PM
 */


namespace admin\views\pages;


class CPanelHomePage extends UserDocument
{
    public function __construct()
    {
        parent::__construct(array('administrator'));

        $this->setVariable("tabTitle", "Control Panel");
        $this->setVariable("mainContent", "<p>Version: " . \CMSVersion::CURRENT_VERSION . "</p>");

        $this->setActionLinks(array(
            array(
                'title' => "Manage Users",
                'href' => 'cpanel/users'
            )
        ));
    }
}