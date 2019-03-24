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

/**
 * Class CompleteSitePage
 *
 * Display for a page stored in the database
 *
 * @package views\pages
 */
abstract class DatabasePage extends HeaderFooterPage
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
        parent::__construct($page);
        $this->page = $page;
        $this->setVariable("tabTitle", $page->getTitle());
    }

    /**
     * @param string $target Variable to target
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostNotFoundException
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