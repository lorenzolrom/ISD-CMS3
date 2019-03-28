<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 6:42 AM
 */


namespace admin\views\pages;


use models\Page;

class PageViewPage extends UserDocument
{
    /**
     * PageViewPage constructor.
     * @param Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     */
    public function __construct(Page $page)
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "View Page: " . $page->getUri());

        $view = new \admin\views\elements\PageView($page);

        $this->setVariable("mainContent", $view->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "Edit Page",
                'href' => "pages/edit/{$page->getId()}"
            ),
            array(
                'title' => "New Element",
                'href' => "elements/new?page={$page->getId()}"
            )
        ));
    }
}