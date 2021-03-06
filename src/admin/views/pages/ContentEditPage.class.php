<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 6:47 PM
 */


namespace admin\views\pages;

use admin\views\forms\ContentForm;
use models\Content;

class ContentEditPage extends FormDocument
{
    /**
     * ContentEditPage constructor.
     * @param Content $content
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Content $content)
    {
        $element = $content->getElementObject();

        parent::__construct(new ContentForm($element, $content), array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Content: " . $content->getName());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}elements/view/{$element->getId()}");
    }
}