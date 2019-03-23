<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:54 PM
 */


namespace views\content;

use views\View;

/**
 * Class Image
 *
 * An image
 *
 * @package views\content
 */
class Image extends Content
{
    /**
     * Image constructor.
     * @param \models\Content $content
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);
        $this->setTemplateFromHTML("Image", View::TEMPLATE_CONTENT);

        $imgAttributes = json_decode($content->getContent(), TRUE);

        // Set source
        $this->setVariable("imgSource", $imgAttributes['imgSource']);

        // Set alt
        $this->setVariable("imgAlt", $imgAttributes['imgAlt']);
    }
}