<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 5:22 PM
 */


namespace views\pages;


use models\Page;
use views\elements\Footer;
use views\elements\Header;

/**
 * Class HeaderFooterPage
 *
 * Page including the site's header and footer
 *
 * @package views\pages
 */
class HeaderFooterPage extends HTML5Page
{
    /**
     * CompleteSitePage constructor.
     * @param Page|null $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?Page $page = NULL)
    {
        parent::__construct();

        $this->setVariable("bodyContent", self::templateFileContents("CompleteSitePage", self::TEMPLATE_PAGE));
        $this->setVariable("siteDescription", \CMSConfiguration::CMS_CONFIG['siteDescription']);

        // Load header and footer
        $header = new Header($page);
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());
    }
}