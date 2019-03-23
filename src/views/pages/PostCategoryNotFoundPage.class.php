<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 6:27 PM
 */


namespace views\pages;


class PostCategoryNotFoundPage extends ErrorPage
{
    public function __construct(\Exception $e)
    {
        parent::__construct();

        // Set tab title
        $this->setVariable("tabTitle", "Category Not Found");

        // Set page title
        $this->setVariable("pageTitle", "Category Not Found");

        // Set error message
        $this->setVariable("errorMessage", $e->getMessage());
    }
}