<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 10:14 AM
 */


namespace views\pages;


class PageNotFoundPage extends ErrorPage
{
    public function __construct(\Exception $e)
    {
        parent::__construct();

        // Set tab title
        $this->setVariable("tabTitle", "Page Not Found");

        // Set page title
        $this->setVariable("pageTitle", "Page Not Found");

        // Set error message
        $this->setVariable("errorMessage", $e->getMessage());
    }
}