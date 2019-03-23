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

use factories\ViewFactory;
use views\View;

class Main extends Element
{
    /**
     * Main constructor.
     * @param \models\Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Element $element)
    {
        $this->areas = ['content'];
        $this->setTemplateFromHTML("Main", View::TEMPLATE_ELEMENT);

        // Load in content
        foreach($this->areas as $area)
        {
            $areaContent = "";

            foreach($element->getContent($area) as $content)
            {
                $areaContent .= ViewFactory::getContentView($content)->getHTML();
            }

            $this->setVariable($area, $areaContent);
        }
    }
}