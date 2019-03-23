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


use views\View;

abstract class Element extends View
{
    protected $areas;

    abstract function __construct(\models\Element $element);

    /**
     * Returns list of valid content areas for this element
     * @return array
     */
    public function getAreas(): array
    {
        return $this->areas;
    }
}