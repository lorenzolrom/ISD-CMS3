<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 4:15 PM
 */


namespace admin\views;


use views\View;

/**
 * Class AdminView
 *
 * Version of
 *
 * @package admin\views
 */
class AdminView extends View
{
    const ADMIN_TEMPLATE_PAGE = '../admin/html/pages';
    const ADMIN_TEMPLATE_FORM = '../admin/html/forms';
    const ADMIN_TEMPLATE_ELEMENT = '../admin/html/elements';
    const ADMIN_TEMPLATE_CONTENT = '../admin/html/content';

    /**
     * Display error message dialog
     *
     * @param array $errors
     * @throws \exceptions\ViewException
     */
    public function setErrors(array $errors)
    {
        $this->setNotifications($errors, 'error', 'Error');
    }

    /**
     * @param array $notices
     * @throws \exceptions\ViewException
     */
    public function setNotices(array $notices)
    {
        $this->setNotifications($notices, 'notice', 'Notice');
    }

    /**
     * @return string
     * @throws \exceptions\ViewException
     */
    public function getHTML(): string
    {
        if(isset($_GET['NOTICE']))
            $this->setNotices(array($_GET['NOTICE']));

        $this->setVariable("siteTitle", \CMSConfiguration::CMS_CONFIG['siteTitle']);
        $this->setVariable("adminURI", \CMSConfiguration::CMS_CONFIG['adminURI']);

        return parent::getHTML(); // TODO: Change the autogenerated stub
    }

    /**
     * @param array $notifications
     * @param string $type
     * @param string $title
     * @throws \exceptions\ViewException
     */
    private function setNotifications(array $notifications, string $type, string $title)
    {
        $notificationString = "<ul>";

        foreach($notifications as $notification)
        {
            $notificationString .= "<li>$notification</li>";
        }

        $notificationString .= "</ul>";

        $this->setVariable("notifications", View::templateFileContents("Notifications", self::ADMIN_TEMPLATE_ELEMENT));
        $this->setVariable("notificationClass", "notifications-$type");
        $this->setVariable("notificationTitle", $title);
        $this->setVariable("notifications", $notificationString);
    }
}