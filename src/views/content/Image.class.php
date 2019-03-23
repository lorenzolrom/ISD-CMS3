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

/**
 * Class Image
 *
 * An image
 *
 * @package views\content
 */
class Image extends Content
{
    public function __construct(\models\Content $content)
    {
        parent::__construct($content);

        $imgAttributes = json_decode($content->getContent());

        // Set source
        $this->setVariable("imgSource", $imgAttributes['imgSource']);

        // Set alt
        $this->setVariable("imgAlt", $imgAttributes['imgAlt']);
    }
}