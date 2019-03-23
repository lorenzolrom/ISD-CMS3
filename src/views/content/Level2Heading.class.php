<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 1:37 PM
 */


namespace views\content;


use views\View;

class Level2Heading extends Content
{
    /**
     * Level2Heading constructor.
     * @param \models\Content $content
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);
        $this->setTemplateFromHTML("Level2Heading", View::TEMPLATE_CONTENT);

        // Raw replace of content
        $pAttributes = json_decode($content->getContent(), TRUE);

        $this->setVariable("content", $pAttributes['content']);
    }
}