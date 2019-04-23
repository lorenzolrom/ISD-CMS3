<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 4/23/2019
 * Time: 5:31 PM
 */


namespace database;


class PageViewDatabaseHandler
{
    /**
     * @param string $url
     * @param string $address
     * @param string $time
     * @throws \exceptions\DatabaseException
     */
    public static function insert(string $url, string $address, string $time): void
    {
        $handler = new DatabaseConnection();

        $insert = $handler->prepare("INSERT INTO `cms_PageView` (`url`, `address`, `time`) VALUES (:url, :address, :time)");
        $insert->bindParam('url', $url, DatabaseConnection::PARAM_STR);
        $insert->bindParam('address', $address, DatabaseConnection::PARAM_STR);
        $insert->bindParam('time', $time, DatabaseConnection::PARAM_STR);
        $insert->execute();

        $handler->close();
    }
}