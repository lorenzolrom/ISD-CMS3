<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:28 PM
 */


namespace models;


use database\ContentDatabaseHandler;
use database\PageDatabaseHandler;
use exceptions\ValidationException;

class Element
{
    const TYPES = array('Main', 'Left Sidebar Main', 'Split');

    const FIELDS = array('name', 'type', 'weight');

    const MESSAGES = array(
        'NAME_LENGTH_ERROR' => "Name Must Be Between 1 and 64 Characters",
        'NAME_NOT_VALID' => "Name Must Contain Only Letters, Numbers, or '-'",
        'TYPE_INVALID' => "Type Not Valid",
        'WEIGHT_INVALID' => "Weight Is Not Valid"
    );

    private $id;
    private $name;
    private $type;
    private $page;
    private $weight;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return Page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     */
    public function getPageObject(): Page
    {
        return PageDatabaseHandler::selectById($this->page);
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param string|null $area
     * @return Content[]
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     */
    public function getContent(string $area = NULL): array
    {
        return ContentDatabaseHandler::selectByElement($this->id, $area);
    }

    /**
     * @param string|null $name
     * @return bool
     * @throws ValidationException
     */
    public static function validateName(?string $name): bool
    {
        if($name === NULL)
            throw new ValidationException(self::MESSAGES['NAME_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($name) < 1)
            throw new ValidationException(self::MESSAGES['NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($name) > 64)
            throw new ValidationException(self::MESSAGES['NAME_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);
        else if(!preg_match("/^[A-Za-z0-9\-\s\/]+$/",$name))
            throw new ValidationException(self::MESSAGES['NAME_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param string|null $type
     * @return bool
     * @throws ValidationException
     */
    public static function validateType(?string $type): bool
    {
        if($type === NULL)
            throw new ValidationException(self::MESSAGES['TYPE_INVALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($type, self::TYPES))
            throw new ValidationException(self::MESSAGES['TYPE_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param int|null $weight
     * @return bool
     * @throws ValidationException
     */
    public static function validateWeight(?int $weight): bool
    {
        if($weight === NULL)
            throw new ValidationException(self::MESSAGES['WEIGHT_INVALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }
}