<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 7:02 PM
 */


namespace views\content;

use views\View;

/**
 * Class Paragraph
 *
 * A paragraph
 *
 * @package views\content
 */
class Paragraph extends Content
{
    /**
     * Paragraph constructor.
     * @param \models\Content $content
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);
        $this->setTemplateFromHTML("Paragraph", View::TEMPLATE_CONTENT);

        $pAttributes = json_decode($content->getContent(), TRUE);

        $this->setVariable("content", $pAttributes['content']);
    }
}