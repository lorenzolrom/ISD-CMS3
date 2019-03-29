<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 8:15 PM
 */


namespace views\pages;


use models\Page;
use views\content\FeaturedPostList;

class HomePage extends DatabasePage
{
    /**
     * HomePage constructor.
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

        $this->setVariable("mainContent", self::templateFileContents("HomePage", self::TEMPLATE_PAGE));

        $featuredPosts = new FeaturedPostList(4);
        $this->setVariable("featuredPosts", $featuredPosts->getHTML());

        $this->loadContent("mainContent");
    }
}