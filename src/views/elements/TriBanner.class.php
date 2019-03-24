<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 12:54 PM
 */


namespace views\elements;

use factories\ViewFactory;
use views\View;

/**
 * Class TriBanner
 *
 * A banner consisting of three images
 *
 * @package views\elements
 */
class TriBanner extends Element
{
    /**
     * TriBanner constructor.
     * @param \models\Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     * @throws \exceptions\PostNotFoundException
     */
    public function __construct(\models\Element $element)
    {
        parent::__construct($element);

        // This element consists of three image tags
        $this->areas = ['image1', 'image2', 'image3'];

        $this->setTemplateFromHTML("TriBanner", View::TEMPLATE_ELEMENT);

        // Add images to banner (the way this works, only the first image loaded will be displayed)
        foreach($this->areas as $area)
        {
            // Get content for this image
            foreach($element->getContent($area) as $content)
            {
                // Ignore if this is not an image
                if($content->getType() != "Image")
                    continue;

                // Load the view for this image and set it to the current area of the banner
                $image = ViewFactory::getContentView($content);
                $this->setVariable($area, $image->getHTML());
            }
        }
    }
}