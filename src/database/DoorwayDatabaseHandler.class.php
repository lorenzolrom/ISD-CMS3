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
}