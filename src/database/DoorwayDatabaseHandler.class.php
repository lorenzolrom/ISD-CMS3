<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:25 AM
 */


namespace database;


use exceptions\DatabaseException;
use exceptions\DoorwayNotFoundException;
use models\Doorway;

class DoorwayDatabaseHandler
{
    /**
     * @param int $id
     * @return Doorway
     * @throws DoorwayNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id): Doorway
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, uri, destination, enabled FROM cms_Doorway WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new DoorwayNotFoundException(DoorwayNotFoundException::MESSAGES[DoorwayNotFoundException::PRIMARY_KEY_NOT_FOUND], DoorwayNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Doorway");
    }

    /**
     * @param string $uri
     * @return Doorway
     * @throws DoorwayNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByUri(string $uri): Doorway
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Doorway WHERE uri = ? LIMIT 1");
        $select->bindParam(1, $uri, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new DoorwayNotFoundException(DoorwayNotFoundException::MESSAGES[DoorwayNotFoundException::UNIQUE_KEY_NOT_FOUND], DoorwayNotFoundException::UNIQUE_KEY_NOT_FOUND);

        return self::selectById($select->fetchColumn());
    }

    /**
     * @return Doorway[]
     * @throws DoorwayNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function select(): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Doorway ORDER BY id ASC");
        $select->execute();

        $handler->close();

        $doorways = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $doorways[] = self::selectById($id);
        }

        return $doorways;
    }

    /**
     * @param string $uri
     * @return bool
     */
    public static function uriInUse(string $uri): bool
    {
        try
        {
            $handler = new DatabaseConnection();

            $select = $handler->prepare("SELECT id FROM cms_Doorway WHERE uri = ? LIMIT 1");
            $select->bindParam(1, $uri, DatabaseConnection::PARAM_STR);
            $select->execute();

            $handler->close();
            return $select->getRowCount() === 1;
        }
        catch(DatabaseException $e)
        {
            return TRUE; // FALSE POSITIVE
        }
    }

    /**
     * @param string $uri
     * @param string $destination
     * @param int $enabled
     * @return Doorway
     * @throws DatabaseException
     * @throws DoorwayNotFoundException
     */
    public static function insert(string $uri, string $destination, int $enabled): Doorway
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_Doorway (uri, destination, enabled) VALUES (:uri, :destination, :enabled)");
        $insert->bindParam('uri', $uri, DatabaseConnection::PARAM_STR);
        $insert->bindParam('destination', $destination, DatabaseConnection::PARAM_STR);
        $insert->bindParam('enabled', $enabled, DatabaseConnection::PARAM_INT);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @param string $uri
     * @param string $destination
     * @param int $enabled
     * @return bool
     * @throws DatabaseException
     */
    public static function update(int $id, string $uri, string $destination, int $enabled): bool
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Doorway SET uri = :uri, destination = :destination, enabled = :enabled WHERE id = :id");
        $update->bindParam('uri', $uri, DatabaseConnection::PARAM_STR);
        $update->bindParam('destination', $destination, DatabaseConnection::PARAM_STR);
        $update->bindParam('enabled', $enabled, DatabaseConnection::PARAM_INT);
        $update->bindParam('id', $id, DatabaseConnection::PARAM_INT);
        $update->execute();

        $handler->close();

        return TRUE;
    }

    /**
     * @param int $id
     * @return bool
     * @throws DatabaseException
     */
    public static function delete(int $id): bool
    {
        $handler = new DatabaseConnection();

        $delete = $handler->prepare("DELETE FROM cms_Doorway WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return TRUE;
    }
}