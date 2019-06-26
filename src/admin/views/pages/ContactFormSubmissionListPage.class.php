<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 8:08 AM
 */


namespace admin\views\pages;


use admin\views\elements\ContactFormSubmissionListTable;

class ContactFormSubmissionListPage extends UserDocument
{
    /**
     * ContactFormSubmissionListPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Contact Submissions");
        $list = new ContactFormSubmissionListTable();
        $this->setVariable("mainContent", $list->getHTML());
    }
}