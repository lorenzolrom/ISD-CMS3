<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:12 PM
 */


namespace views\pages;

use factories\ViewFactory;
use models\Page;
use views\elements\Footer;
use views\elements\Header;
use views\View;

/**
 * Class BasicPage
 *
 * A basic page with a single content area
 *
 * @package views
 */
class BasicPage extends HTML5Page
{
    /**
     * BasicPage constructor.
     * @param Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page)
    {
        parent::__construct();
        $this->setVariable("bodyContent", self::templateFileContents("BasicPage", View::TEMPLATE_PAGE));

        // Set tab title to <pageTitle> | <siteTitle>
        $this->setVariable("tabTitle", $page->getTitle() . " | " . \CMSConfiguration::CMS_CONFIG['siteTitle']);
        $this->setVariable("siteDescription", \CMSConfiguration::CMS_CONFIG['siteDescription']);
        $this->setVariable("pageTitle", $page->getTitle());

        // Load header and footer
        $header = new Header();
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());

        // Retrieve elements
        $content = "";

        foreach($page->getElements() as $element)
        {
            $content .= ViewFactory::getElementView($element)->getHTML();
        }

        $this->setVariable("mainContent", $content);
    }
}