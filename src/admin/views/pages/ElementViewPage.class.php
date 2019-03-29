<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:35 AM
 */


namespace admin\views\pages;


use admin\views\elements\ElementView;
use models\Element;

class ElementViewPage extends UserDocument
{
    /**
     * ElementViewPage constructor.
     * @param Element $element
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\ContentNotFoundException
     */
    public function __construct(Element $element)
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "View Element: " . $element->getName());

        $view = new ElementView($element);

        $this->setVariable("mainContent", $view->getHTML());

        $this->setActionLinks(array(
            array(
                'title' => "Edit Element",
                'href' => "elements/edit/{$element->getId()}"
            ),
            array(
                'title' => "New Content",
                'href' => "content/new?element={$element->getId()}"
            ),
        ));
    }
}