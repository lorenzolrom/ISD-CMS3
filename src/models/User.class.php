<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:29 PM
 */


namespace models;


class User
{
    private $id;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $displayName;
    private $email;
    private $disabled;
    private $role;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getDisabled(): int
    {
        return $this->disabled;
    }

    /**
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Validate if the supplied password is correct
     * @param string $password
     * @return bool
     */
    public function isCorrectPassword(string $password): bool
    {
        if(hash('SHA512', hash('SHA512', $password)) == $this->password)
            return TRUE;

        return FALSE;
    }

    /**
     * Return display name if it is set, first + last name if it is not
     *
     * @return string
     */
    public function getName(): string
    {
        if($this->displayName !== NULL)
            return $this->displayName;

        return $this->firstName . " " . $this->lastName;
    }
}