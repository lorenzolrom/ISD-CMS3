<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 12:52 PM
 */


namespace views\pages;

use models\Page;

/**
 * Class NoTitlePage
 *
 * A site page without an H1 title
 *
 * @package views\pages
 */
class NoTitlePage extends DatabasePage
{
    /**
     * NoTitlePage constructor.
     * @param Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ContentNotFoundException
     */
    public function __construct(Page $page)
    {
        parent::__construct($page);

        $this->loadContent("mainContent");
    }
}