<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:30 AM
 */


namespace database;


use exceptions\ContentNotFoundException;
use models\Content;

class ContentDatabaseHandler
{
    /**
     * @param int $id
     * @return Content
     * @throws ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id): Content
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, type, author, element, area, content, weight, classes FROM cms_Content WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new ContentNotFoundException(ContentNotFoundException::MESSAGES[ContentNotFoundException::PRIMARY_KEY_NOT_FOUND], ContentNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Content");
    }

    /**
     * @param int $elementId
     * @param string|null $area What area of the element to get content for?  If null selects all
     * @param bool $asc Should content be sorted by weight?  Default TRUE
     * @return Content[]
     * @throws ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByElement(int $elementId, ?string $area = NULL, bool $asc = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Content WHERE element = ?" . ($area !== NULL ? " AND area = ?" : "") . ($asc ? " ORDER BY weight ASC" : ""));
        $select->bindParam(1, $elementId, DatabaseConnection::PARAM_INT);

        if($area !== NULL)
            $select->bindParam(2, $area, DatabaseConnection::PARAM_STR);

        $select->execute();

        $handler->close();

        $content = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $content[] = self::selectById($id);
        }

        return $content;
    }

    /**
     * @param string $filter
     * @return Content[]
     * @throws ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByContent(string $filter): array
    {
        $handler = new DatabaseConnection();

        $filter = "%$filter%";

        $select = $handler->prepare("SELECT id FROM cms_Content WHERE content LIKE ?");
        $select->bindParam(1, $filter, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        $content = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $content[] = self::selectById($id);
        }

        return $content;
    }
}