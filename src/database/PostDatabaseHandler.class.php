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
     * @return Post[]
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

        $select = $handler->prepare("SELECT id FROM cms_Post WHERE title LIKE :filter OR content LIKE :filter");
        $select->bindParam('filter', $filter, DatabaseConnection::PARAM_STR);
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
     * @param int|null $category
     * @param int|null $author
     * @param string $date
     * @param string $title
     * @param string $content
     * @param string|null $previewImage
     * @param int $displayed
     * @param int $featured
     * @return Post
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(?int $category, ?int $author, string $date, string $title, string $content, ?string $previewImage, int $displayed, int $featured): Post
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_Post (category, author, date, title, content, previewImage, displayed, featured) VALUES (:category, :author, :date, :title, :content, :previewImage, :displayed, :featured)");
        $insert->bindParam('category', $category, DatabaseConnection::PARAM_INT);
        $insert->bindParam('author', $author, DatabaseConnection::PARAM_INT);
        $insert->bindParam('date', $date, DatabaseConnection::PARAM_STR);
        $insert->bindParam('title', $title, DatabaseConnection::PARAM_STR);
        $insert->bindParam('content', $content, DatabaseConnection::PARAM_STR);
        $insert->bindParam('previewImage', $previewImage, DatabaseConnection::PARAM_STR);
        $insert->bindParam('displayed', $displayed, DatabaseConnection::PARAM_INT);
        $insert->bindParam('featured', $featured, DatabaseConnection::PARAM_INT);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @param int|null $category
     * @param int|null $author
     * @param string $date
     * @param string $title
     * @param string $content
     * @param string|null $previewImage
     * @param int $displayed
     * @param int $featured
     * @return Post
     * @throws PostNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function update(int $id, ?int $category, ?int $author, string $date, string $title, string $content, ?string $previewImage, int $displayed, int $featured): Post
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Post SET category = :category, author = :author, date = :date, title = :title, content = :content, previewImage = :previewImage, displayed = :displayed, featured = :featured WHERE id = :id");
        $update->bindParam('category', $category, DatabaseConnection::PARAM_INT);
        $update->bindParam('id', $id, DatabaseConnection::PARAM_INT);
        $update->bindParam('author', $author, DatabaseConnection::PARAM_INT);
        $update->bindParam('date', $date, DatabaseConnection::PARAM_STR);
        $update->bindParam('title', $title, DatabaseConnection::PARAM_STR);
        $update->bindParam('content', $content, DatabaseConnection::PARAM_STR);
        $update->bindParam('previewImage', $previewImage, DatabaseConnection::PARAM_STR);
        $update->bindParam('displayed', $displayed, DatabaseConnection::PARAM_INT);
        $update->bindParam('featured', $featured, DatabaseConnection::PARAM_INT);
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

        $delete = $handler->prepare("DELETE FROM cms_Post WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }
}