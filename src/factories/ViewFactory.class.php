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
use views\elements\LeftSidebarMain;
use views\elements\Main;
use views\elements\Split;
use views\pages\BasicPage;
use views\pages\HomePage;
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
     */
    public static function getContentView(Content $content): View
    {
        return new \views\content\Content($content);
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
        switch($element->getType())
        {
            case "Main":
                return new Main($element);
                break;
            case "Split":
                return new Split($element);
                break;
            case "Left Sidebar Main":
                return new LeftSidebarMain($element);
                break;
            default:
                throw new ViewException(ViewException::MESSAGES[ViewException::ELEMENT_NOT_FOUND], ViewException::ELEMENT_NOT_FOUND);
        }
    }

    /**
     * @param Page $page
     * @return View
     * @throws ViewException
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
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
            case "Home":
                return new HomePage($page);
                break;
            default:
                throw new ViewException(ViewException::MESSAGES[ViewException::PAGE_NOT_FOUND], ViewException::PAGE_NOT_FOUND);
        }
    }
}