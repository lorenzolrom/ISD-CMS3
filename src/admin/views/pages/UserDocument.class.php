<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 6:43 PM
 */


namespace admin\views\pages;

use admin\views\elements\Header;

/**
 * Class UserDocument
 *
 * Base page for an authenticated user.  Includes header and footer
 *
 * @package admin\views\pages
 */
abstract class UserDocument extends AuthenticatedPage
{
    /**
     * UserDocument constructor.
     * @param array|null $roles
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(?array $roles = NULL)
    {
        parent::__construct($roles);
        $this->setTemplateFromHTML("HTML5Document", self::ADMIN_TEMPLATE_PAGE);

        $this->setVariable("bodyContent", self::templateFileContents("UserDocument", self::ADMIN_TEMPLATE_PAGE));

        $header = new Header($this->user);
        $this->setVariable("headerContent", $header->getHTML());
    }

    /**
     * @param array $links
     */
    public function setActionLinks(array $links)
    {
        $linkString = "";

        foreach($links as $link)
        {
            $linkString .= "<li><a href='{{@baseURI}}{{@adminURI}}{$link['href']}'>{$link['title']}</a></li>\n";
        }

        $this->setVariable("sidebarLinks", $linkString);
    }
}