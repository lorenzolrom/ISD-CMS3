<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 4:52 PM
 */


namespace admin\views\pages;

use admin\views\forms\ContentForm;
use exceptions\PageNotFoundException;
use models\Element;

class ContentNewPage extends UserDocument
{
    /**
     * ContentNewPage constructor.
     * @param Element $element
     * @throws PageNotFoundException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Element $element)
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "New Content");

        $form = new ContentForm($element);

        $this->setVariable("mainContent", $form->getHTML());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}elements/view/{$element->getId()}");
    }
}