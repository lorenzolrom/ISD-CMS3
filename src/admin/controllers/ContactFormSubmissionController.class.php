<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 8:07 AM
 */


namespace admin\controllers;

use admin\views\pages\AuthenticatedPage;
use admin\views\pages\ContactFormSubmissionListPage;
use admin\views\pages\ContactFormSubmissionViewPage;
use database\ContactFormSubmissionDatabaseHandler;
use exceptions\PageNotFoundException;

class ContactFormSubmissionController extends Controller
{

    /**
     * @return string
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     * @throws \exceptions\EntryNotFoundException
     */
    public function getPage(): string
    {
        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new ContactFormSubmissionListPage();
                return $page->getHTML();
            case 'delete':
                return $this->delete();
            case 'view':
                return $this->view();
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\EntryNotFoundException
     * @throws \exceptions\SecurityException
     */
    private function delete()
    {
        $id = array_shift($this->uriParts);
        $contact = ContactFormSubmissionDatabaseHandler::selectById((int)$id);

        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        ContactFormSubmissionDatabaseHandler::delete($contact->getId());

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "contacts?NOTICE=Contact Submission Deleted");
        exit;
    }

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\EntryNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\SecurityException
     */
    private function view(): string
    {
        $id = array_shift($this->uriParts);
        $submission = ContactFormSubmissionDatabaseHandler::selectById((int)$id);
        $view = new ContactFormSubmissionViewPage($submission);
        return $view->getHTML();
    }
}