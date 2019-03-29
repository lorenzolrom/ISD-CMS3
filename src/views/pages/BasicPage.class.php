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

use models\Page;

/**
 * Class BasicPage
 *
 * A basic page with a single content area
 *
 * @package views
 */
class BasicPage extends DatabasePage
{
    /**
     * BasicPage constructor.
     * @param Page $page
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page)
    {
        parent::__construct($page);

        // Import the BasicPage template
        $this->setVariable("mainContent", self::templateFileContents("BasicPage", self::TEMPLATE_PAGE));

        // Set page title
        $this->setVariable("pageTitle", $page->getTitle());

        $this->loadContent("mainContent");
    }
}