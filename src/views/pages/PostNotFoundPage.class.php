<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:50 PM
 */


namespace views\pages;


class PostNotFoundPage  extends ErrorPage
{
    public function __construct(\Exception $e)
    {
        parent::__construct();

        // Set tab title
        $this->setVariable("tabTitle", "Post Not Found");

        // Set page title
        $this->setVariable("pageTitle", "Post Not Found");

        // Set error message
        $this->setVariable("errorMessage", $e->getMessage());
    }
}