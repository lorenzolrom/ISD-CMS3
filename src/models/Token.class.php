<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 5:25 PM
 */


namespace models;


use database\TokenDatabaseHandler;
use exceptions\SecurityException;

class Token
{
    private $token;
    private $user;
    private $issueTime;
    private $expireTime;
    private $expired;
    private $ipAddress;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getIssueTime(): string
    {
        return $this->issueTime;
    }

    /**
     * @param string $issueTime
     */
    public function setIssueTime(string $issueTime): void
    {
        $this->issueTime = $issueTime;
    }

    /**
     * @return string
     */
    public function getExpireTime(): string
    {
        return $this->expireTime;
    }

    /**
     * @param string $expireTime
     */
    public function setExpireTime(string $expireTime): void
    {
        $this->expireTime = $expireTime;
    }

    /**
     * @return int
     */
    public function getExpired(): int
    {
        return $this->expired;
    }

    /**
     * @param int $expired
     * @return bool
     * @throws \exceptions\DatabaseException
     */
    public function setExpired(int $expired): bool
    {
        return TokenDatabaseHandler::updateExpired($expired);
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return bool
     * @throws SecurityException
     * @throws \exceptions\DatabaseException
     */
    public function isValid(): bool
    {
        $isAfterExpireTime = strtotime(date("Y-m-d H:i:s")) > strtotime($this->expireTime);

        if($isAfterExpireTime)
            $this->setExpired(1);

        if($this->expired === 1 OR $isAfterExpireTime)
        {
            throw new SecurityException(SecurityException::MESSAGE[SecurityException::TOKEN_EXPIRED], SecurityException::TOKEN_EXPIRED);
        }

        return TRUE;
    }

}