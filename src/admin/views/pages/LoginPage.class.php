<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 3:50 PM
 */


namespace admin\views\pages;


use admin\views\AdminView;

class LoginPage extends AdminView
{
    /**
     * LoginPage constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $this->setTemplateFromHTML("HTML5Document", self::ADMIN_TEMPLATE_PAGE);
        $this->setVariable("bodyContent", self::templateFileContents("LoginForm", self::ADMIN_TEMPLATE_FORM));
        $this->setVariable("siteTitle", \CMSConfiguration::CMS_CONFIG['siteTitle']);
        $this->setVariable("tabTitle", "Login");
    }
}