<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:16 AM
 */


namespace database;


use exceptions\PageNotFoundException;
use models\Page;

class PageDatabaseHandler
{
    /**
     * @param int $id
     * @return Page
     * @throws \exceptions\DatabaseException
     * @throws PageNotFoundException
     */
    public static function selectById(int $id): Page
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, type, author, uri, title, navTitle, previewImage, isOnNav, weight, protected FROM cms_Page WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        // Throw exception if page not found
        if($select->getRowCount() !== 1)
            throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND] . ": $id", PageNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Page");
    }

    /**
     * @param string $uri
     * @return Page
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByUri(string $uri): Page
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Page WHERE uri = ? LIMIT 1");
        $select->bindParam(1, $uri, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::UNIQUE_KEY_NOT_FOUND] . ": $uri", PageNotFoundException::UNIQUE_KEY_NOT_FOUND);

        return self::selectById($select->fetchColumn());
    }

    /**
     * @param bool $onNav
     * @param bool $byWeight
     * @return Page[]
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function select(bool $onNav = FALSE, bool $byWeight = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_Page" . ($onNav ? " WHERE isOnNav = 1" : "") . ($byWeight ? " ORDER BY weight ASC" : ""));
        $select->execute();

        $handler->close();

        $pages = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $pages[] = self::selectById($id);
        }

        return $pages;
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

            $select = $handler->prepare("SELECT id FROM cms_Page WHERE uri = ? LIMIT 1");
            $select->bindParam(1, $uri, DatabaseConnection::PARAM_STR);
            $select->execute();

            $handler->close();

            return $select->getRowCount() === 1;
        }
        catch(\Exception $e)
        {
            return TRUE;
        }
    }

    /**
     * @param string $type
     * @param int|null $author
     * @param string $uri
     * @param string $title
     * @param string|null $navTitle
     * @param string|null $previewImage
     * @param int $isOnNav
     * @param int $weight
     * @param int $protected
     * @return Page
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $type, ?int $author, string $uri, string $title, ?string $navTitle, ?string $previewImage, int $isOnNav, int $weight, int $protected): Page
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO cms_Page (type, author, uri, title, navTitle, previewImage, isOnNav, weight, protected) VALUES (:type, :author, :uri, :title, :navTitle, :previewImage, :isOnNav, :weight, :protected)");
        $insert->bindParam('type', $type, DatabaseConnection::PARAM_STR);
        $insert->bindParam('author', $author, DatabaseConnection::PARAM_INT);
        $insert->bindParam('uri', $uri, DatabaseConnection::PARAM_STR);
        $insert->bindParam('title', $title, DatabaseConnection::PARAM_STR);
        $insert->bindParam('navTitle', $navTitle, DatabaseConnection::PARAM_STR);
        $insert->bindParam('previewImage', $previewImage, DatabaseConnection::PARAM_STR);
        $insert->bindParam('isOnNav', $isOnNav, DatabaseConnection::PARAM_INT);
        $insert->bindParam('weight', $weight, DatabaseConnection::PARAM_INT);
        $insert->bindParam('protected', $protected, DatabaseConnection::PARAM_INT);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param int $id
     * @param string $type
     * @param string $uri
     * @param string $title
     * @param string|null $navTitle
     * @param string|null $previewImage
     * @param int $isOnNav
     * @param int $weight
     * @param int $protected
     * @return Page
     * @throws PageNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function update(int $id, string $type, string $uri, string $title, ?string $navTitle, ?string $previewImage, int $isOnNav, int $weight, int $protected): Page
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Page SET type = :type, uri = :uri, title = :title, navTitle = :navTitle, previewImage = :previewImage, isOnNav = :isOnNav, weight = :weight, protected = :protected WHERE id = :id");
        $update->bindParam('type', $type, DatabaseConnection::PARAM_STR);
        $update->bindParam('uri', $uri, DatabaseConnection::PARAM_STR);
        $update->bindParam('title', $title, DatabaseConnection::PARAM_STR);
        $update->bindParam('navTitle', $navTitle, DatabaseConnection::PARAM_STR);
        $update->bindParam('previewImage', $previewImage, DatabaseConnection::PARAM_STR);
        $update->bindParam('isOnNav', $isOnNav, DatabaseConnection::PARAM_INT);
        $update->bindParam('weight', $weight, DatabaseConnection::PARAM_INT);
        $update->bindParam('protected', $protected, DatabaseConnection::PARAM_INT);
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

        $delete = $handler->prepare("DELETE FROM cms_Page WHERE id = ?");
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }
}