<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 7:50 AM
 */


namespace database;


use exceptions\EntryNotFoundException;
use models\ContactFormSubmission;

class ContactFormSubmissionDatabaseHandler
{
    /**
     * @param int $id
     * @return ContactFormSubmission
     * @throws EntryNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectById(int $id): ContactFormSubmission
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare('SELECT `id`, `time`, `ipAddress`, `name`, `email`, `comment` FROM `cms_ContactFormSubmission` WHERE `id` = ? LIMIT 1');
        $select->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $select->execute();

        $handler->close();

        if($select->getRowCount() === 1)
            return $select->fetchObject('models\ContactFormSubmission');

        throw new EntryNotFoundException(EntryNotFoundException::MESSAGES[EntryNotFoundException::PRIMARY_KEY_NOT_FOUND], EntryNotFoundException::PRIMARY_KEY_NOT_FOUND);
    }

    /**
     * @return ContactFormSubmission[]
     * @throws \exceptions\DatabaseException
     */
    public static function select(): array
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare('SELECT `id` FROM `cms_ContactFormSubmission`');
        $select->execute();

        $handler->close();

        $submissions = array();

        foreach($select->fetchAll(DatabaseConnection::FETCH_COLUMN, 0) as $id)
        {
            try
            {
                $submissions[] = self::selectById($id);
            }
            catch(EntryNotFoundException $e){}
        }

        return $submissions;
    }

    /**
     * @param string $time
     * @param string $ipAddress
     * @param string $name
     * @param string $email
     * @param string $comments
     * @return ContactFormSubmission
     * @throws EntryNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $ipAddress, string $name, string $email, string $comments): ContactFormSubmission
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare('INSERT INTO `cms_ContactFormSubmission` (`time`, `ipAddress`, `name`, `email`, `comment`) 
          VALUES (NOW(), :ipAddress, :name, :email, :comment)');

        $insert->bindParam('ipAddress', $ipAddress, DatabaseConnection::PARAM_STR);
        $insert->bindParam('name', $name, DatabaseConnection::PARAM_STR);
        $insert->bindParam('email', $email, DatabaseConnection::PARAM_STR);
        $insert->bindParam('comment', $comments, DatabaseConnection::PARAM_STR);
        $insert->execute();

        $id = $handler->getLastInsertId();

        $handler->close();

        return self::selectById($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws \exceptions\DatabaseException
     */
    public static function delete($id): bool {
        $handler = new DatabaseConnection();

        $delete = $handler->prepare('DELETE FROM `cms_ContactFormSubmission` WHERE `id` = ?');
        $delete->bindParam(1, $id, DatabaseConnection::PARAM_INT);
        $delete->execute();

        $handler->close();

        return $delete->getRowCount() === 1;
    }
}