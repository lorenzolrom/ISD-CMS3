<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 1:34 PM
 */


namespace admin\views\forms;


use models\User;

class PasswordChangeForm extends Form
{
    private $user;

    /**
     * PasswordChangeForm constructor.
     * @param User $user
     * @throws \exceptions\ViewException
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setTemplateFromHTML("PasswordChangeForm", self::ADMIN_TEMPLATE_FORM);
    }

    /**
     * Returns any validation errors encountered when the form is submitted
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        if(!isset($_POST['current']) OR strlen($_POST['current']) < 1)
        {
            $errors[] = "Current Password Required";
        }
        else if(!$this->user->isCorrectPassword($_POST['current']))
        {
            $errors[] = "Current Password Is Incorrect";
        }
        else if(!isset($_POST['new']) OR strlen($_POST['new']) < 1)
        {
            $errors[] = "New Password Required";
        }
        else if(!isset($_POST['confirm']) OR $_POST['new'] != $_POST['confirm'])
        {
            $errors[] = "New Passwords Do Not Match";
        }

        return $errors;
    }
}