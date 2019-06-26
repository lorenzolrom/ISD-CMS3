<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 8:52 AM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use models\ContactFormSubmission;

class ContactFormSubmissionView extends AdminView
{
    /**
     * ContactFormSubmissionView constructor.
     * @param ContactFormSubmission $submission
     * @throws \exceptions\ViewException
     */
    public function __construct(ContactFormSubmission $submission)
    {
        $this->setTemplateFromHTML('ContactFormSubmissionView', self::ADMIN_TEMPLATE_ELEMENT);

        $this->setVariable('name', htmlentities($submission->getName()));
        $this->setVariable('email', htmlentities($submission->getEmail()));
        $this->setVariable('comment', htmlentities($submission->getComment()));
        $this->setVariable('time', htmlentities($submission->getTime()));
        $this->setVariable('ipAddress', htmlentities($submission->getIpAddress()));
    }
}