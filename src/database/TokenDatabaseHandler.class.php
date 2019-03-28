<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 7:30 PM
 */


namespace database;


use exceptions\TokenNotFoundException;
use models\Token;
use models\User;

class TokenDatabaseHandler
{
    /**
     * @param string $token
     * @return Token
     * @throws TokenNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function selectByToken(string $token): Token
    {
        $handler = new DatabaseConnection();

        $select = $handler->prepare("SELECT token, user, issueTime, expireTime, expired, ipAddress FROM cms_Token WHERE token = ? LIMIT 1");
        $select->bindParam(1, $token, DatabaseConnection::PARAM_STR);
        $select->execute();

        $handler->close();

        if($select->getRowCount() !== 1)
            throw new TokenNotFoundException(TokenNotFoundException::MESSAGES[TokenNotFoundException::PRIMARY_KEY_NOT_FOUND], TokenNotFoundException::PRIMARY_KEY_NOT_FOUND);

        return $select->fetchObject("models\Token");
    }

    /**
     * @param User $user
     * @return Token
     * @throws TokenNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public static function create(User $user): Token
    {
        $handler = new DatabaseConnection();

        $token = hash('SHA512', openssl_random_pseudo_bytes(2048));
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $id = $user->getId();

        $create = $handler->prepare("INSERT INTO cms_Token (token, user, issueTime, expireTime, ipAddress) VALUES (:token, :user, NOW(), NOW() + INTERVAL 1 HOUR, :ipAddress)");
        $create->bindParam('token', $token, DatabaseConnection::PARAM_STR);
        $create->bindParam('user', $id, DatabaseConnection::PARAM_INT);
        $create->bindParam('ipAddress', $ipAddress, DatabaseConnection::PARAM_STR);
        $create->execute();

        $handler->close();

        return self::selectByToken($token);
    }

    /**
     * @param int $expired
     * @param string $token
     * @return bool
     * @throws \exceptions\DatabaseException
     */
    public static function updateExpired(int $expired, string $token): bool
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Token SET expired = ? WHERE token = ?");
        $update->bindParam(1, $expired, DatabaseConnection::PARAM_INT);
        $update->bindParam(2, $token, DatabaseConnection::PARAM_STR);
        $update->execute();

        $handler->close();

        return $update->getRowCount() === 1;
    }

    /**
     * @param string $token
     * @return bool
     * @throws \exceptions\DatabaseException
     */
    public static function updateExpireTime(string $token): bool
    {
        $handler = new DatabaseConnection();

        $update = $handler->prepare("UPDATE cms_Token SET expireTime = NOW() + INTERVAL 1 HOUR WHERE token = ?");
        $update->bindParam(1, $token, DatabaseConnection::PARAM_STR);
        $update->execute();

        $handler->close();

        return $update->getRowCount() === 1;
    }
}