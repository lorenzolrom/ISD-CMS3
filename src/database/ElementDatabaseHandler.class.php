<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:24 AM
 */


namespace database;


use exceptions\ElementNotFoundException;
use models\Element;

class ElementDatabaseHandler
{
    /**
     * @param int $id
     * @return Element
     * @throws \exceptions\DatabaseException
     * @throws ElementNotFoundException
     */
    public static function selectById(int $id): Element
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, name, type, page, weight FROM cms_Element WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new ElementNotFoundException(ElementNotFoundException::MESSAGES[ElementNotFoundException::PRIMARY_KEY_NOT_FOUND], ElementNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Element");
    }

    /**
     * @param int $pageId
     * @param bool $asc Should we sort by weight ascending?  Default TRUE
     * @return Element[]
     * @throws ElementNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByPage(int $pageId, bool $asc = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Element WHERE page = ?" . ($asc ? " ORDER BY weight ASC" : ""));
        $select->bindParam(1, $pageId, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        $elements = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $elements[] = self::selectById($id);
        }

        return $elements;
    }

    /**
     * @param string $name
     * @param string $type
     * @param int $page
     * @param int $weight
     * @return Element
     * @throws ElementNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $name, string $type, int $page, int $weight): Element
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_Element (name, type, page, weight) VALUES (:name, :type, :page, :weight)");
        $insert->bindParam('name', $name, DatabaseConnection::PARAM_STR);
        $insert->bindParam('type', $type, DatabaseConnection::PARAM_STR);
        $insert->bindParam('page', $page, DatabaseConnection::PARAM_INT);
        $insert->bindParam('weight', (int)$weight, DatabaseConnection::PARAM_INT);
        $insert->execute();

        $id = $handler->getLastInsertId();

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

        $delete = $handler->prepare("DELETE FROM cms_Element WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $type
     * @param int $weight
     * @return Element
     * @throws ElementNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function update(int $id, string $name, string $type, int $weight): Element
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Element SET name = :name, type = :type, weight = :weight WHERE id = :id");
        $update->bindParam('name', $name, DatabaseConnection::PARAM_STR);
        $update->bindParam('type', $type, DatabaseConnection::PARAM_STR);
        $update->bindParam('weight', $weight, DatabaseConnection::PARAM_INT);
        $update->bindParam('id', $id, DatabaseConnection::PARAM_INT);
        $update->execute();

        $handler->close();

        return self::selectById($id);
    }
}