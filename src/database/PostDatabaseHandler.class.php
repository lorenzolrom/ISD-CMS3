<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:15 PM
 */


namespace database;


use exceptions\PostNotFoundException;
use models\Post;

class PostDatabaseHandler
{
    /**
     * @param int $id
     * @return Post
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id): Post
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, category, author, date, title, content, previewImage, displayed, featured FROM cms_Post WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new PostNotFoundException(PostNotFoundException::MESSAGES[PostNotFoundException::PRIMARY_KEY_NOT_FOUND] . ": $id", PostNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Post");
    }

    /**
     * @param bool $displayedOnly
     * @return array
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectAll(bool $displayedOnly = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Post" . ($displayedOnly ? " WHERE displayed = 1" : "") . " ORDER BY title ASC");
        $select->execute();

        $handler->close();

        $posts = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $posts[] = self::selectById($id);
        }

        return $posts;
    }

    /**
     * @param int $categoryId
     * @param bool $displayedOnly Only select posts marked as 'displayed', default to TRUE
     * @return array
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByCategory(int $categoryId, bool $displayedOnly = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Post WHERE category = ?" . ($displayedOnly ? " AND displayed = 1" : "") . " ORDER BY title ASC");
        $select->bindParam(1, $categoryId, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        $posts = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $posts[] = self::selectById($id);
        }

        return $posts;
    }

    /**
     * @param int|null $limit
     * @param bool $displayedOnly
     * @return array
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByFeatured(?int $limit = NULL, bool $displayedOnly = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Post WHERE featured = 1" . ($displayedOnly ? " AND displayed = 1" : "") . (($limit !== NULL) ? " ORDER BY RAND() LIMIT $limit" : ""));
        $select->execute();

        $handler->close();

        $posts = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $posts[] = self::selectById($id);
        }

        return $posts;
    }

    /**
     * @param string $filter
     * @return Post[]
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByContent(string $filter): array
    {
        $handler = new DatabaseConnection();

        // Add wildcards
        $filter = "%$filter%";

        $select = $handler->prepare("SELECT id FROM cms_Post WHERE content LIKE ?");
        $select->bindParam(1, $filter, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        $posts = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $posts[] = self::selectById($id);
        }

        return $posts;
    }
}