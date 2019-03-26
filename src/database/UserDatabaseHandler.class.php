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
}