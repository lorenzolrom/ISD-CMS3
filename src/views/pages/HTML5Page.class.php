<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:05 PM
 */


namespace views\pages;

use views\View;

/**
 * Class HTML5Page
 *
 * A blank HTML page with the HTML5 doctype
 *
 * @package views
 */
abstract class HTML5Page extends View
{
    /**
     * BasePage constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        // Load default HTML5 template
        $this->setTemplateFromHTML("HTML5Document", self::TEMPLATE_PAGE);
    }
}