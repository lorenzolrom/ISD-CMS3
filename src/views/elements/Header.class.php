<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:47 PM
 */


namespace views\elements;


use views\View;

class Header extends View
{
    /**
     * Header constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $this->setTemplateFromHTML("Header", View::TEMPLATE_ELEMENT);
    }
}