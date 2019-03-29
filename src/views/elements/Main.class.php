<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:13 AM
 */


namespace views\elements;

use views\View;

class Main extends Element
{
    const AREAS = array('content');

    /**
     * Main constructor.
     * @param \models\Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Element $element)
    {
        parent::__construct($element);
        $this->areas = self::AREAS;
        $this->setTemplateFromHTML("Main", View::TEMPLATE_ELEMENT);

        $this->loadContent();
    }
}