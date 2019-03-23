<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 10:17 AM
 */


namespace views\pages;


class FatalErrorPage extends ErrorPage
{
    public function __construct(\Exception $e)
    {
        parent::__construct();

        // Set tab title
        $this->setVariable("tabTitle", "An Error Occurred");

        // Set page title
        $this->setVariable("pageTitle", "Whoops...");

        // Set error message
        $this->setVariable("errorMessage", $e->getMessage());
    }
}