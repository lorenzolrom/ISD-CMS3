<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 7:26 AM
 */


namespace views\pages;


use database\ContactFormSubmissionDatabaseHandler;
use exceptions\DatabaseException;
use exceptions\EntryNotFoundException;
use models\Page;

class ContactPage extends DatabasePage
{
    /**
     * GuestbookPage constructor.
     * @param Page $page
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page)
    {
        parent::__construct($page);

        $this->setVariable("mainContent", self::templateFileContents("ContactPage", self::TEMPLATE_PAGE));

        $this->setVariable("pageTitle", $page->getTitle());

        $this->loadContent("mainContent");

        if(!empty($_POST))
        {
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $comments = strip_tags($_POST['comments']);
            $ipAddress = $_SERVER['REMOTE_ADDR'];

            if(strlen($name) > 0 AND strlen($comments) > 0 AND (strlen($email) === 0 OR filter_var($email, FILTER_VALIDATE_EMAIL)))
            {
                try
                {
                    ContactFormSubmissionDatabaseHandler::insert($ipAddress, $name, $email, $comments);
                    echo "<script>alert('Form submitted successfully')</script>";
                }
                catch(\Exception $e)
                {
                    echo "<script>alert('Form could not be submitted')</script>";
                }
            }
            else
            {
                echo "<script>alert('Name and comments required, email must be blank or valid')</script>";
            }
        }
    }
}