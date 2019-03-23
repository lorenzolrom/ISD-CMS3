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

        $select = $handler->prepare("SELECT id, type, author, uri, title, navTitle, isOnNav FROM cms_Page WHERE id = ? LIMIT 1");
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
}