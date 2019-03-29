<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:10 AM
 */


namespace views\elements;


use factories\ViewFactory;
use views\View;

abstract class Element extends View
{
    protected $areas;
    protected $element;

    function __construct(\models\Element $element)
    {
        $this->element = $element;
    }

    /**
     * Returns list of valid content areas for this element
     * @return array
     */
    public function getAreas(): array
    {
        return $this->areas;
    }

    /**
     * Auto-loads content into specified areas for elements using the default process
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    protected function loadContent()
    {
        // Load in content
        foreach($this->areas as $area)
        {
            $areaContent = "";

            foreach($this->element->getContent($area) as $content)
            {
                $areaContent .= ViewFactory::getContentView($content)->getHTML();
            }

            $this->setVariable($area, $areaContent);
        }
    }
}