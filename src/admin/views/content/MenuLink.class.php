<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 11:37 AM
 */


namespace admin\views\content;


use admin\views\AdminView;

class MenuLink extends AdminView
{
    /**
     * MenuLink constructor.
     * @param string $title
     * @param string $href
     * @throws \exceptions\ViewException
     */
    public function __construct(string $title, string $href)
    {
        $this->setTemplateFromHTML("MenuLink", self::ADMIN_TEMPLATE_CONTENT);
        $this->setVariable("title", $title);
        $this->setVariable("href", $href);
    }
}