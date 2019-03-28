<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:24 AM
 */


namespace models;

use database\DoorwayDatabaseHandler;
use exceptions\ValidationException;

/**
 * Class Doorway
 *
 * A pass-through url
 *
 * @package models
 */
class Doorway
{
    const MESSAGES = array(
        'URI_LENGTH_ERROR' => "URI Must Be Between 1 and 255 Characters",
        'URI_ALREADY_TAKEN' => "URI Already In Use",
        'DESTINATION_REQUIRED' => "Destination Required",
        'ENABLED_NOT_VALID' => "Enabled Not Valid"
    );

    private $id;
    private $uri;
    private $destination;
    private $enabled;

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
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getEnabled(): int
    {
        return $this->enabled;
    }

    /**
     * @param string|null $uri
     * @return bool
     * @throws ValidationException
     */
    public static function validateURI(?string $uri): bool
    {
        if($uri === NULL) // Not null
            throw new ValidationException(self::MESSAGES['URI_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($uri) < 1) // Not too short
            throw new ValidationException(self::MESSAGES['URI_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($uri) > 255) // Not too long
            throw new ValidationException(self::MESSAGES['URI_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);
        else if(DoorwayDatabaseHandler::uriInUse($uri)) // Not already in use
            throw new ValidationException(self::MESSAGES['URI_ALREADY_TAKEN'], ValidationException::VALUE_ALREADY_TAKEN);

        return TRUE;
    }

    /**
     * @param string|null $destination
     * @return bool
     * @throws ValidationException
     */
    public static function validateDestination(?string $destination): bool
    {
        if($destination === NULL)
            throw new ValidationException(self::MESSAGES['DESTINATION_REQUIRED'], ValidationException::VALUE_IS_NULL);
        else if(strlen($destination) < 1)
            throw new ValidationException(self::MESSAGES['DESTINATION_REQUIRED'], ValidationException::VALUE_TOO_SHORT);

        return TRUE;
    }

    /**
     * @param int|null $enabled
     * @return bool
     * @throws ValidationException
     */
    public static function validateEnabled(?int $enabled): bool
    {
        if($enabled === NULL)
            throw new ValidationException(self::MESSAGES['ENABLED_NOT_VALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($enabled, array(0, 1)))
            throw new ValidationException(self::MESSAGES['ENABLED_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }
}