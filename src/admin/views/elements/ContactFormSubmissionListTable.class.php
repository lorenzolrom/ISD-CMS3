<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 8:11 AM
 */


namespace admin\views\elements;


use database\ContactFormSubmissionDatabaseHandler;

class ContactFormSubmissionListTable extends ListTable
{
    /**
     * ContactFormSubmissionListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $rows = array();

        foreach(ContactFormSubmissionDatabaseHandler::select() as $submission)
        {
            $rows[] = array(
                'id' => $submission->getId(),
                'cells' => array(
                    'name' => $submission->getName(),
                    'time' => $submission->getTime(),
                    'email' => $submission->getEmail(),
                    'comments' => substr($submission->getComment(), 0, 25) . (strlen($submission->getComment()) > 25 ? '...' : '')
                )
            );
        }

        parent::__construct('contacts', $rows, TRUE);
        $this->setHeader(array('Name', 'Time', 'Email', 'Comments'));
    }
}