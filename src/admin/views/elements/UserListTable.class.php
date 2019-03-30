<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 8:50 PM
 */


namespace admin\views\elements;


use database\UserDatabaseHandler;

class UserListTable extends ListTable
{
    /**
     * UserListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $rows = array();

        foreach(UserDatabaseHandler::select() as $user)
        {
            $rows[] = array(
                'id' => $user->getId(),
                'cells' => array(
                    'username' => $user->getUsername(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'displayName' => $user->getDisplayName(),
                    'role' => $user->getRole(),
                    'disabled' => ($user->getDisabled() ? "✓" : "")
                )
            );
        }

        parent::__construct("cpanel/users", $rows);
        $this->setHeader(array('Username', 'First Name', 'Last Name', 'Display Name', 'Role', 'Disabled'));
    }
}