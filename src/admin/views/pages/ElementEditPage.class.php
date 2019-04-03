<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 2:07 PM
 */


namespace admin\views\pages;


use admin\views\forms\ElementForm;
use database\PageDatabaseHandler;
use models\Element;

class ElementEditPage extends FormDocument
{
    /**
     * ElementEditPage constructor.
     * @param Element $element
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(Element $element)
    {
        $page = PageDatabaseHandler::selectById($element->getPage());
        parent::__construct(new ElementForm($page, $element), array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Element: " . $element->getName());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}elements/view/{$element->getId()}");
    }
}