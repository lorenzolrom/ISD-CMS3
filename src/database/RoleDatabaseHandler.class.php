<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 9:12 PM
 */


namespace database;


use exceptions\RoleNotFoundException;
use models\Role;

class RoleDatabaseHandler
{
    /**
     * @param string $code
     * @return Role
     * @throws RoleNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByCode(string $code): Role
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT code, displayName FROM cms_Role WHERE code = ? LIMIT 1");
        $select->bindParam(1, $code, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new RoleNotFoundException(RoleNotFoundException::MESSAGES[RoleNotFoundException::PRIMARY_KEY_NOT_FOUND], RoleNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Role");
    }

    /**
     * @return Role[]
     * @throws RoleNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function select(): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT code FROM cms_Role");
        $select->execute();

        $handler->close();

        $roles = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $code)
        {
            $roles[] = self::selectByCode($code);
        }

        return $roles;
    }
}