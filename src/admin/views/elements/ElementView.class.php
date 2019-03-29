<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:15 AM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use database\PageDatabaseHandler;
use models\Element;

class ElementView extends AdminView
{
    /**
     * ElementView constructor.
     * @param Element $element
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ContentNotFoundException
     */
    public function __construct(Element $element)
    {
        $this->setTemplateFromHTML("ElementView", self::ADMIN_TEMPLATE_ELEMENT);

        $page = PageDatabaseHandler::selectById($element->getPage());

        $this->setVariable("pageId", $page->getId());
        $this->setVariable("pageURI", htmlentities($page->getUri()));
        $this->setVariable("pageTitle", htmlentities($page->getTitle()));

        $this->setVariable("name", htmlentities($element->getName()));
        $this->setVariable("type", htmlentities($element->getType()));
        $this->setVariable("weight", $element->getWeight());

        $contentList = new ContentListTable($element);
        $this->setVariable("contentList", $contentList->getHTML());
    }
}