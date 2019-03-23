<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 7:01 PM
 */


namespace views\content;

/**
 * Class Raw
 *
 * Raw HTML to render to user directly
 *
 * @package views\content
 */
class Raw extends Content
{
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);

        // Raw replace of content
        $this->setVariable("content", $content->getContent());
    }
}