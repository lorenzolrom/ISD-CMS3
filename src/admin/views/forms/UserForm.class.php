<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 9:08 PM
 */


namespace admin\views\forms;


use database\RoleDatabaseHandler;
use exceptions\ValidationException;
use models\User;

class UserForm extends Form
{
    private $user;

    /**
     * UserForm constructor.
     * @param User|null $user
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?User $user = NULL)
    {
        $this->user = $user;
        $this->setTemplateFromHTML("UserForm", self::ADMIN_TEMPLATE_FORM);

        if($user !== NULL)
        {
            $this->setVariable("username", $user->getUsername());
            $this->setVariable("firstName", $user->getFirstName());
            $this->setVariable("lastName", $user->getLastName());
            $this->setVariable("email", $user->getEmail());
            $this->setVariable("displayName", $user->getDisplayName());

            // Disabled
            if($user->getDisabled())
                $this->setVariable("disabledYes", self::SELECTED);
        }
        else
        {
            // Password fields required
            $this->setVariable("passwordRequired", "required");
        }

        if(isset($_POST['disabled']) AND $_POST['disabled'] == 1)
            $this->setVariable("disabledYes", self::SELECTED);

        // Role Select
        $roleSelect = "";

        foreach(RoleDatabaseHandler::select() as $role)
        {
            if(($user !== NULL AND $role->getCode() == $user->getRole()) OR (isset($_POST['role']) AND $_POST['role'] == $role->getCode()))
                $selected = "selected";
            else
                $selected = "";

            $roleSelect .= "<option value='{$role->getCode()}' $selected>{$role->getDisplayName()}</option>";
        }

        $this->setVariable("roleSelect", $roleSelect);
    }

    /**
     * Returns any validation errors encountered when the form is submitted
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(User::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $field)
        {
            $fields[$field] = $_POST[$field];
        }

        if($this->user !== NULL AND $this->user->getUsername() != $fields['username'])
        {
            try
            {
                User::validateUsername($fields['username']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            User::validateFirstName($fields['firstName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateLastName($fields['lastName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateDisplayName($fields['displayName']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        if($this->user !== NULL AND $this->user->getEmail() != $fields['email'])
        {
            try
            {
                User::validateEmail($fields['email']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            User::validateDisabled((int)$fields['disabled']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            User::validateRole($fields['role']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        if($this->user !== NULL AND ($fields['password'] !== NULL AND strlen($fields['password']) > 0))
        {
            try
            {
                User::validatePassword($fields['password'], $fields['confirm']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }
}