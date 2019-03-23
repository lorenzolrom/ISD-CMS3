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

        $select = $handler->prepare("SELECT id, name, page, weight FROM cms_Element WHERE id = ? LIMIT 1");
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
}