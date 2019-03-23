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
use views\View;

abstract class ErrorPage extends HTML5Page
{
    public function __construct(\Exception $e)
    {
        parent::__construct();

        // Set to a basic page
        $this->setVariable("bodyContent", self::templateFileContents("BasicPage", View::TEMPLATE_PAGE));

        // Load header and footer
        $header = new Header();
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());

        // Add error message
        $this->setVariable("mainContent", self::templateFileContents("ErrorMessage", View::TEMPLATE_ELEMENT));

        // TODO: Footer/header
    }
}