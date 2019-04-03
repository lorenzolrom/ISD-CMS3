<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 7:29 PM
 */


namespace admin\views\forms;


use admin\views\AdminView;

abstract class Form extends AdminView
{
    const SELECTED = "selected";

    /**
     * Populates form with existing data
     * Then returns template instead of HTML so calling view can do processing
     * @return string
     */
    public function getHTML(): string
    {
        foreach(array_keys($_POST) as $input)
        {
            $this->setVariable($input, $_POST[$input]);
        }

        return parent::getTemplate();
    }

    /**
     * Returns any validation errors encountered when the form is submitted
     * @return array
     */
    abstract public function validate(): array;
}