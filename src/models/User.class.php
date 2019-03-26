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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getDisabled(): int
    {
        return $this->disabled;
    }

    /**
     * @param int $disabled
     */
    public function setDisabled(int $disabled): void
    {
        $this->disabled = $disabled;
    }

    /**
     * @return int
     */
    public function getRole(): ?int
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole(?int $role): void
    {
        $this->role = $role;
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
}