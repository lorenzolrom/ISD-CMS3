<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 8:37 PM
 */


namespace views\elements;


class LeftSidebarMain extends Element
{
    const AREAS = array('sidebarContent', 'content');

    /**
     * LeftSidebarMain constructor.
     * @param \models\Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Element $element)
    {
        parent::__construct($element);
        $this->areas = self::AREAS;
        $this->setTemplateFromHTML("LeftSidebarMain", self::TEMPLATE_ELEMENT);

        $this->loadContent();
    }
}