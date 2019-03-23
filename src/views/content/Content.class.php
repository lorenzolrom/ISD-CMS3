<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 8:59 AM
 */


namespace views\content;


use views\View;

abstract class Content extends View
{
    protected $content;

    /**
     * Content constructor.
     * @param \models\Content $content
     */
    public function __construct(\models\Content $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        $this->setClasses();
        return parent::getHTML();
    }

    /**
     * Adds custom classes from database, if specified
     */
    private function setClasses()
    {
        // Replace classes if they exist
        if($this->content->getClasses() !== NULL)
        {
            $this->setVariable("classes", " class='{$this->content->getClasses()}'");
        }
    }
}