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

class Level3Heading extends Content
{
    /**
     * Level3Heading constructor.
     * @param \models\Content $content
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);
        $this->setTemplateFromHTML("Level3Heading", View::TEMPLATE_CONTENT);

        // Raw replace of content
        $pAttributes = json_decode($content->getContent(), TRUE);

        $this->setVariable("content", $pAttributes['content']);
    }
}