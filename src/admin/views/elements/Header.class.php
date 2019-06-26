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

        // Display user's name
        if($user->getDisplayName() !== NULL)
            $userDisplayName = $user->getDisplayName();
        else
            $userDisplayName = $user->getFirstName() . " " . $user->getLastName();

        $this->setVariable("userDisplayName", $userDisplayName);

        // Add navigation links
        $navigationContent = "";

        // Posts, Categories (author, editor, administrator)
        if(in_array($user->getRole(), array('author', 'editor', 'administrator')))
        {
            $postLink = new MenuLink('Posts', 'posts');
            $navigationContent .= $postLink->getHTML();
        }

        // Pages, Content, Doorways, Files (editor, administrator)
        if(in_array($user->getRole(), array('editor', 'administrator')))
        {
            $pageLink = new MenuLink('Pages', 'pages');
            $doorwayLink = new MenuLink('Doorways', 'doorways');
            $contactLink = new MenuLink('Contact Submissions', 'contacts');
            $fileLink = new MenuLink('Files', 'files');

            $navigationContent .= $pageLink->getHTML() . $doorwayLink->getHTML() . $contactLink->getHTML() . $fileLink->getHTML();
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