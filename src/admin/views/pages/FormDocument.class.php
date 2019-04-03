<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 4/03/2019
 * Time: 4:46 PM
 */


namespace admin\views\pages;


use admin\views\forms\Form;

abstract class FormDocument extends UserDocument
{
    protected $form;

    /**
     * FormDocument constructor.
     * @param array|null $roles
     * @param Form $form
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct($form, ?array $roles = NULL)
    {
        $this->form = $form;
        parent::__construct($roles);

        $this->setVariable("mainContent", $form->getHTML());
    }

    /**
     * Returns results of validation on form attribute
     * @return array
     */
    public function getFormErrors(): array
    {
        return $this->form->validate();
    }
}