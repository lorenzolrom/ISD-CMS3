<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 7:15 AM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use admin\views\content\MenuLink;
use models\User;

class Header extends AdminView
{
    /**
     * Header constructor.
     * @param User $user
     * @throws \exceptions\ViewException
     */
    public function __construct(User $user)
    {
        $this->setTemplateFromHTML("Header", self::ADMIN_TEMPLATE_ELEMENT);

        // Add navigation links
        $navigationContent = "";

        // Posts, Categories (author, editor, administrator)
        if(in_array($user->getRole(), array('author', 'editor', 'administrator')))
        {
            $postLink = new MenuLink('Posts', 'posts');
            $categoryLink = new MenuLink('Categories', 'categories');

            $navigationContent .= $postLink->getHTML() . $categoryLink->getHTML();
        }

        // Pages, Content, Doorways, Files (editor, administrator)
        if(in_array($user->getRole(), array('editor', 'administrator')))
        {
            $pageLink = new MenuLink('Pages', 'pages');
            $contentLink = new MenuLink('Content', 'content');
            $doorwayLink = new MenuLink('Doorways', 'doorways');
            $fileLink = new MenuLink('Files', 'files');

            $navigationContent .= $pageLink->getHTML() . $contentLink->getHTML() . $doorwayLink->getHTML() . $fileLink->getHTML();
        }

        // Control Panel (administrator)
        if($user->getRole() == "administrator")
        {
            $cpanelLink = new MenuLink('Control Panel', 'cpanel');

            $navigationContent .= $cpanelLink->getHTML();
        }

        $this->setVariable("navigationContent", $navigationContent);
    }
}