<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 6:44 AM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use database\UserDatabaseHandler;

class PageView extends AdminView
{
    /**
     * Page constructor.
     * @param \models\Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ElementNotFoundException
     */
    public function __construct(\models\Page $page)
    {
        $this->setTemplateFromHTML("PageView", self::ADMIN_TEMPLATE_ELEMENT);

        $this->setVariable("uri", htmlentities($page->getUri()));
        $this->setVariable("title", htmlentities($page->getTitle()));
        $this->setVariable("navTitle", htmlentities($page->getNavTitle()));
        $this->setVariable("type", $page->getType());
        $this->setVariable("isOnNav", ($page->getIsOnNav() == 1 ? "Yes" : "No"));
        $this->setVariable("weight", $page->getWeight());

        if($page->getAuthor() !== NULL)
            $this->setVariable("authorName", htmlentities(UserDatabaseHandler::selectById($page->getAuthor())->getName()));

        $elementList = new ElementListTable($page);
        $this->setVariable("elementList", $elementList->getHTML());
    }
}