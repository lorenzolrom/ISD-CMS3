<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/9/2019
 * Time: 2:45 PM
 */


namespace database;


use exceptions\DatabaseException;

class DatabaseConnection
{
    // Fetch Types
    const FETCH_ASSOC = \PDO::FETCH_ASSOC;
    const FETCH_COLUMN = \PDO::FETCH_COLUMN;

    // Parameter Types
    const PARAM_NULL = \PDO::PARAM_NULL;
    const PARAM_INT = \PDO::PARAM_INT;
    const PARAM_STR = \PDO::PARAM_STR;
    const PARAM_BOOL = \PDO::PARAM_BOOL;

    private $handler; // Database interaction object

    /**
     * DatabaseConnection constructor.
     * @throws DatabaseException
     */
    public function __construct()
    {
        try
        {
            $this->handler = new \PDO("mysql:host=" . \CMSConfiguration::CMS_CONFIG['databaseHost'] . ";dbname=" . \CMSConfiguration::CMS_CONFIG['databaseName'],
                \CMSConfiguration::CMS_CONFIG['databaseUser'], \CMSConfiguration::CMS_CONFIG['databasePassword'],
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOCH));
        }
        catch(\PDOException $e)
        {
            throw new DatabaseException(DatabaseException::MESSAGES[DatabaseException::FAILED_TO_CONNECT], DatabaseException::FAILED_TO_CONNECT, $e);
        }
    }
}