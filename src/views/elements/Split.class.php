<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 1:30 PM
 */


namespace views\elements;


use views\View;

class Split extends Element
{
    /**
     * Split constructor.
     * @param \models\Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Element $element)
    {
        parent::__construct($element);

        $this->areas = ['leftContent', 'rightContent'];
        $this->setTemplateFromHTML("Split", View::TEMPLATE_ELEMENT);

        $this->loadContent();
    }
}