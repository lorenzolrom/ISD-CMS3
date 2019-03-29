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

        $select = $handler->prepare("SELECT id, name, author, element, area, content, weight FROM cms_Content WHERE id = ? LIMIT 1");
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

    /**
     * @param string $name
     * @param int|null $author
     * @param int $element
     * @param string $area
     * @param string $content
     * @param int $weight
     * @return Content
     * @throws ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $name, ?int $author, int $element, string $area, string $content, int $weight): Content
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_Content (name, author, element, area, content, weight) VALUES (:name, :author, :element, :area, :content, :weight)");
        $insert->bindParam('name', $name, DatabaseConnection::PARAM_STR);
        $insert->bindParam('author', $author, DatabaseConnection::PARAM_INT);
        $insert->bindParam('element', $element, DatabaseConnection::PARAM_INT);
        $insert->bindParam('area', $area, DatabaseConnection::PARAM_STR);
        $insert->bindParam('content', $content, DatabaseConnection::PARAM_STR);
        $insert->bindParam('weight', $weight, DatabaseConnection::PARAM_INT);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @param string $name
     * @param int|null $author
     * @param int $element
     * @param string $area
     * @param string $content
     * @param int $weight
     * @return Content
     * @throws ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function update(int $id, string $name, ?int $author, int $element, string $area, string $content, int $weight): Content
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Content SET name = :name, author = :author, element = :element, area = :area, content = :content, weight = :weight WHERE id = :id");
        $update->bindParam('name', $name, DatabaseConnection::PARAM_STR);
        $update->bindParam('author', $author, DatabaseConnection::PARAM_INT);
        $update->bindParam('element', $element, DatabaseConnection::PARAM_INT);
        $update->bindParam('area', $area, DatabaseConnection::PARAM_STR);
        $update->bindParam('content', $content, DatabaseConnection::PARAM_STR);
        $update->bindParam('weight', $weight, DatabaseConnection::PARAM_INT);
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

        $delete = $handler->prepare("DELETE FROM cms_Content WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }
}