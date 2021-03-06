<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 10:09 AM
 */


namespace views\pages;


use views\elements\Footer;
use views\elements\Header;

abstract class ErrorPage extends HTML5Page
{
    /**
     * ErrorPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct();

        // Set to a basic page
        $this->setVariable("bodyContent", self::templateFileContents("CompleteSitePage", self::TEMPLATE_PAGE));
        $this->setVariable("mainContent", self::templateFileContents("BasicPage", self::TEMPLATE_PAGE));

        // Load header and footer
        $header = new Header();
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());

        // Add error message
        $this->setVariable("mainContent", self::templateFileContents("ErrorMessage", self::TEMPLATE_ELEMENT));
    }
}