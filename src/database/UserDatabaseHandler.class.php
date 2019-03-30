<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 6:57 PM
 */


namespace database;


use exceptions\UserNotFoundException;
use models\User;

class UserDatabaseHandler
{
    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id):User
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, username, firstName, lastName, password, displayName, email, disabled, role FROM cms_User WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new UserNotFoundException(UserNotFoundException::MESSAGES[UserNotFoundException::PRIMARY_KEY_NOT_FOUND], UserNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("\models\User");
    }

    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByUsername(string $username): User
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_User WHERE username = ? LIMIT 1");
        $select->bindParam(1, $username, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new UserNotFoundException(UserNotFoundException::MESSAGES[UserNotFoundException::UNIQUE_KEY_NOT_FOUND], UserNotFoundException::UNIQUE_KEY_NOT_FOUND);

        return self::selectById($select->fetchColumn());
    }

    /**
     * @return User[]
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function select(): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_User");
        $select->execute();

        $handler->close();

        $users = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $users[] = self::selectById($id);
        }

        return $users;
    }

    /**
     * @param string $username
     * @return bool
     */
    public static function usernameInUse(string $username): bool
    {
        try
        {
            $handler = new DatabaseConnection();

            $select = $handler->prepare("SELECT id FROM cms_User WHERE username = ? LIMIT 1");
            $select->bindParam(1, $username, DatabaseConnection::PARAM_STR);
            $select->execute();

            $handler->close();

            return $select->getRowCount() === 1;
        }
        catch(\Exception $e)
        {
            return TRUE; //FALSE POSITIVE
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function emailInUse(string $email): bool
    {
        try
        {
            $handler = new DatabaseConnection();

            $select = $handler->prepare("SELECT id FROM cms_User WHERE email = ? LIMIT 1");
            $select->bindParam(1, $email, DatabaseConnection::PARAM_STR);
            $select->execute();

            $handler->close();

            return $select->getRowCount() === 1;
        }
        catch(\Exception $e)
        {
            return TRUE; //FALSE POSITIVE
        }
    }

    /**
     * @param int $id
     * @param string $password
     * @return User
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function updatePassword(int $id, string $password): User
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_User SET password = :password WHERE id = :id");
        $update->bindParam("password", $password, DatabaseConnection::PARAM_STR);
        $update->bindParam("id", $id, DatabaseConnection::PARAM_INT);
        $update->execute();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string|null $displayName
     * @param string $email
     * @param int $disabled
     * @param string $role
     * @return User
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $username, string $password, string $firstName, string $lastName, ?string $displayName, string $email, int $disabled, string $role): User
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_User (username, password, firstName, lastName, displayName, email, disabled, role) VALUES 
                                              (:username, :password, :firstName, :lastName, :displayName, :email, :disabled, :role)");
        $insert->bindParam('username', $username, DatabaseConnection::PARAM_STR);
        $insert->bindParam('password', $password, DatabaseConnection::PARAM_STR);
        $insert->bindParam('firstName', $firstName, DatabaseConnection::PARAM_STR);
        $insert->bindParam('lastName', $lastName, DatabaseConnection::PARAM_STR);
        $insert->bindParam('displayName', $displayName, DatabaseConnection::PARAM_STR);
        $insert->bindParam('email', $email, DatabaseConnection::PARAM_STR);
        $insert->bindParam('disabled', $disabled, DatabaseConnection::PARAM_INT);
        $insert->bindParam('role', $role, DatabaseConnection::PARAM_STR);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string|null $displayName
     * @param string $email
     * @param int $disabled
     * @param string $role
     * @return User
     * @throws UserNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function update(int $id, string $username, string $firstName, string $lastName, ?string $displayName, string $email, int $disabled, string $role): User
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_User SET username = :username, firstName = :firstName, lastName = :lastName, displayName = :displayName, email = :email, disabled = :disabled, role = :role WHERE id = :id");
        $update->bindParam('username', $username, DatabaseConnection::PARAM_STR);
        $update->bindParam('firstName', $firstName, DatabaseConnection::PARAM_STR);
        $update->bindParam('lastName', $lastName, DatabaseConnection::PARAM_STR);
        $update->bindParam('displayName', $displayName, DatabaseConnection::PARAM_STR);
        $update->bindParam('email', $email, DatabaseConnection::PARAM_STR);
        $update->bindParam('disabled', $disabled, DatabaseConnection::PARAM_INT);
        $update->bindParam('role', $role, DatabaseConnection::PARAM_STR);
        $update->bindParam('id', $id, DatabaseConnection::PARAM_INT);
        $update->execute();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \exceptions\DatabaseException
     */
    public static function delete(int $id): bool
    {
        $handler = new DatabaseConnection();

        $delete = $handler->prepare("DELETE FROM cms_User WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }
}