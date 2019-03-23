<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 8:51 AM
 */


namespace factories;

use exceptions\ViewException;
use models\Content;
use models\Element;
use models\Page;
use views\content\Image;
use views\content\Level2Heading;
use views\content\Paragraph;
use views\content\Raw;
use views\elements\Main;
use views\elements\Split;
use views\elements\TriBanner;
use views\pages\BasicPage;
use views\pages\NoTitlePage;
use views\View;

/**
 * Class ViewFactory
 * @package factories
 */
class ViewFactory
{
    /**
     * @param Content $content
     * @return View
     * @throws ViewException
     */
    public static function getContentView(Content $content): View
    {
        switch($content->getType())
        {
            case "Level 2 Heading":
                return new Level2Heading($content);
                break;
            case "Image":
                return new Image($content);
                break;
            case "Paragraph":
                return new Paragraph($content);
                break;
            case "Raw":
                return new Raw($content);
                break;
            default:
                throw new ViewException(ViewException::MESSAGES[ViewException::VIEW_NOT_FOUND], ViewException::VIEW_NOT_FOUND);
        }
    }

    /**
     * @param Element $element
     * @return \views\elements\Element
     * @throws ViewException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function getElementView(Element $element): \views\elements\Element
    {
        switch($element->getName())
        {
            case "Main":
                return new Main($element);
                break;
            case "Tri-Banner":
                return new TriBanner($element);
                break;
            case "Split":
                return new Split($element);
                break;
            default:
                throw new ViewException(ViewException::MESSAGES[ViewException::ELEMENT_NOT_FOUND], ViewException::ELEMENT_NOT_FOUND);
        }
    }

    /**
     * @param Page $page
     * @return View
     * @throws ViewException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\PageNotFoundException
     */
    public static function getPageView(Page $page): View
    {
        switch($page->getType())
        {
            case "Basic":
                return new BasicPage($page);
                break;
            case "No Title":
                return new NoTitlePage($page);
                break;
            default:
                throw new ViewException(ViewException::MESSAGES[ViewException::PAGE_NOT_FOUND], ViewException::PAGE_NOT_FOUND);
        }
    }
}