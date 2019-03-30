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


use database\UserDatabaseHandler;
use exceptions\ValidationException;

class User
{
    const FIELDS = array('username', 'firstName', 'lastName', 'role', 'email', 'displayName', 'password', 'confirm', 'disabled');

    const MESSAGES = array(
        'USERNAME_LENGTH_ERROR' => "Username Must Be Between 1 and 64 Characters",
        'USERNAME_ALREADY_TAKEN' => "Username Already In Use",
        'PASSWORD_REQUIRED' => "Password Required",
        'PASSWORD_NO_MATCH' => "Passwords Do Not Match",
        'FIRST_NAME_LENGTH_ERROR' => "First Name Must Be Between 1 and 32 Characters",
        'LAST_NAME_LENGTH_ERROR' => "Last Name Must Be Between 1 and 32 Characters",
        'EMAIL_REQUIRED' => "Email Address Required",
        'EMAIL_INVALID' => "Email Address Invalid",
        'DISABLED_INVALID' => "Disabled Invalid",
        'ROLE_INVALID' => "Role Invalid",
        'USERNAME_INVALID' => "Username Must Only Contain Letters And Numbers",
        'FIRST_NAME_INVALID' => "First Name Must Only Contain Letters And '-'",
        'LAST_NAME_INVALID' => "Last Name Must Only Contain Letters And '-'",
        'DISPLAY_NAME_INVALID' => "Display Name Must Only Contain Letters, Numbers, '-',  '.', '(', and ')'",
        'EMAIL_ALREADY_TAKEN' => "Email Already In Use"
    );

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
        if(self::hashPassword($password) == $this->password)
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

    /**
     * Double SHA512 the provided string
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return hash('SHA512', hash('SHA512', $password));
    }

    /**
     * @param string|null $username
     * @return bool
     * @throws ValidationException
     */
    public static function validateUsername(?string $username): bool
    {
        if($username === NULL)
            throw new ValidationException(self::MESSAGES['USERNAME_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(UserDatabaseHandler::usernameInUse($username))
            throw new ValidationException(self::MESSAGES['USERNAME_ALREADY_TAKEN'], ValidationException::VALUE_ALREADY_TAKEN);
        else if(strlen($username) < 1)
            throw new ValidationException(self::MESSAGES['USERNAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($username) > 64)
            throw new ValidationException(self::MESSAGES['USERNAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);
        else if(!ctype_alnum($username))
            throw new ValidationException(self::MESSAGES['USERNAME_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $firstName
     * @return bool
     * @throws ValidationException
     */
    public static function validateFirstName(?string $firstName): bool
    {
        if($firstName === NULL)
            throw new ValidationException(self::MESSAGES['FIRST_NAME_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($firstName) < 1)
            throw new ValidationException(self::MESSAGES['FIRST_NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($firstName) > 64)
            throw new ValidationException(self::MESSAGES['FIRST_NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);
        else if(!preg_match("/^[A-Za-z\-\s\/]+$/",$firstName))
            throw new ValidationException(self::MESSAGES['FIRST_NAME_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $lastName
     * @return bool
     * @throws ValidationException
     */
    public static function validateLastName(?string $lastName): bool
    {
        if($lastName === NULL)
            throw new ValidationException(self::MESSAGES['LAST_NAME_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($lastName) < 1)
            throw new ValidationException(self::MESSAGES['LAST_NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($lastName) > 64)
            throw new ValidationException(self::MESSAGES['LAST_NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);
        else if(!preg_match("/^[A-Za-z\-\s\/]+$/",$lastName))
            throw new ValidationException(self::MESSAGES['LAST_NAME_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $displayName
     * @return bool
     * @throws ValidationException
     */
    public static function validateDisplayName(?string $displayName): bool
    {
        if($displayName !== NULL AND strlen($displayName) !== 0 AND !preg_match("/^[A-Za-z0-9().\-\s\/]+$/",$displayName))
            throw new ValidationException(self::MESSAGES['DISPLAY_NAME_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $email
     * @return bool
     * @throws ValidationException
     */
    public static function validateEmail(?string $email): bool
    {
        if($email === NULL)
            throw new ValidationException(self::MESSAGES['EMAIL_REQUIRED'], ValidationException::VALUE_IS_NULL);
        else if(UserDatabaseHandler::emailInUse($email))
            throw new ValidationException(self::MESSAGES['EMAIL_ALREADY_TAKEN'], ValidationException::VALUE_ALREADY_TAKEN);
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new ValidationException(self::MESSAGES['EMAIL_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param int|null $disabled
     * @return bool
     * @throws ValidationException
     */
    public static function validateDisabled(?int $disabled): bool
    {
        if($disabled === NULL)
            throw new ValidationException(self::MESSAGES['DISABLED_INVALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($disabled, array(0, 1)))
            throw new ValidationException(self::MESSAGES['DISABLED_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $role
     * @return bool
     * @throws ValidationException
     */
    public static function validateRole(?string $role): bool
    {
        if($role === NULL)
            throw new ValidationException(self::MESSAGES['ROLE_INVALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($role, Role::ROLES))
            throw new ValidationException(self::MESSAGES['ROLE_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $password
     * @param string|null $confirm
     * @return bool
     * @throws ValidationException
     */
    public static function validatePassword(?string $password, ?string $confirm): bool
    {
        if($password === NULL)
            throw new ValidationException(self::MESSAGES['PASSWORD_REQUIRED'], ValidationException::VALUE_IS_NULL);
        else if(strlen($password) < 1)
            throw new ValidationException(self::MESSAGES['PASSWORD_REQUIRED'], ValidationException::VALUE_TOO_LONG);
        else if($password != $confirm)
            throw new ValidationException(self::MESSAGES['PASSWORD_NO_MATCH'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }
}