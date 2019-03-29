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

class Content extends View
{
    protected $content;

    /**
     * Content constructor.
     * @param \models\Content $content
     */
    public function __construct(\models\Content $content)
    {
        $this->setTemplate($content->getContent());
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        return parent::getHTML();
    }
}