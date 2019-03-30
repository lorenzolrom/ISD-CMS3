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
use models\User;

class UserForm extends Form
{
    /**
     * UserForm constructor.
     * @param User|null $user
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\RoleNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?User $user = NULL)
    {
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
}