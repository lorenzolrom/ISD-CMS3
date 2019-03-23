<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:21 PM
 */


namespace database;


use exceptions\PostCategoryNotFoundException;
use models\PostCategory;

class PostCategoryDatabaseHandler
{
    /**
     * @param int $id
     * @return PostCategory
     * @throws PostCategoryNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id):PostCategory
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id, title, previewImage, displayed FROM cms_PostCategory WHERE id = ? LIMIT 1");
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new PostCategoryNotFoundException(PostCategoryNotFoundException::MESSAGES[PostCategoryNotFoundException::PRIMARY_KEY_NOT_FOUND], PostCategoryNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\PostCategory");
    }

    /**
     * @param bool $displayedOnly
     * @return PostCategory[]
     * @throws \exceptions\DatabaseException
     * @throws PostCategoryNotFoundException
     */
    public static function selectAll(bool $displayedOnly = TRUE): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT id FROM cms_PostCategory" . ($displayedOnly ? " WHERE displayed = 1" : "") . " ORDER BY title ASC");
        $select->execute();

        $handler->close();

        $categories = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            $categories[] = self::selectById($id);
        }

        return $categories;
    }
}