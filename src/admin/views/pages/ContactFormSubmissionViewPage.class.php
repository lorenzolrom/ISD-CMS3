<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 8:57 AM
 */


namespace admin\views\pages;


use admin\views\elements\ContactFormSubmissionView;
use models\ContactFormSubmission;

class ContactFormSubmissionViewPage extends UserDocument
{
    /**
     * ContactFormSubmissionViewPage constructor.
     * @param ContactFormSubmission $submission
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(ContactFormSubmission $submission)
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", 'View Contact Submission');

        $view = new ContactFormSubmissionView($submission);
        $this->setVariable("mainContent", $view->getHTML());
    }
}