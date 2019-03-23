<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 12:45 PM
 */


namespace views\pages;

use factories\ViewFactory;
use models\Page;
use views\elements\Footer;
use views\elements\Header;
use views\View;

/**
 * Class CompleteSitePage
 *
 * A page with the site's header and footer
 *
 * @package views\pages
 */
abstract class CompleteSitePage extends HTML5Page
{
    protected $page;

    /**
     * CompleteSitePage constructor.
     * @param Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page)
    {
        parent::__construct();
        $this->page = $page;

        $this->setVariable("bodyContent", self::templateFileContents("CompleteSitePage", View::TEMPLATE_PAGE));

        $this->setVariable("tabTitle", $page->getTitle());
        $this->setVariable("siteDescription", \CMSConfiguration::CMS_CONFIG['siteDescription']);

        // Load header and footer
        $header = new Header($page);
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());
    }

    /**
     * @param string $target Variable to target
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ViewException
     */
    protected function loadContent(string $target)
    {
        // Retrieve elements
        $content = "";

        foreach($this->page->getElements() as $element)
        {
            $content .= ViewFactory::getElementView($element)->getHTML();
        }

        $this->setVariable($target, $content);
    }
}