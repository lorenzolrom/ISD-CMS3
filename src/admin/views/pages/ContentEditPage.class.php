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

class ContentEditPage extends UserDocument
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
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Content: " . $content->getName());

        $element = $content->getElementObject();

        $form = new ContentForm($element, $content);
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}elements/view/{$element->getId()}");
    }
}