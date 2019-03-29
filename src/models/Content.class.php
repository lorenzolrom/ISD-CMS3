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


use database\ElementDatabaseHandler;
use exceptions\ValidationException;

class Content
{
    const FIELDS = array('name', 'weight', 'area', 'content');

    const MESSAGES = array(
        'AREA_NOT_VALID' => 'Element Area Not Valid',
        'CONTENT_NOT_VALID' => 'Content Not Valid',
        'WEIGHT_NOT_VALID' => "Weight Not Valid",
        'NAME_LENGTH_ERROR' => "Name Must Be Between 1 And 64 Characters"
    );

    private $id;
    private $name;
    private $author;
    private $element;
    private $area;
    private $content;
    private $weight;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getAuthor(): ?int
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getElement(): int
    {
        return $this->element;
    }

    /**
     * @return Element
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     */
    public function getElementObject(): Element
    {
        return ElementDatabaseHandler::selectById($this->element);
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
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
     * @param string|null $area
     * @return bool
     * @throws ValidationException
     */
    public static function validateArea(?string $area): bool
    {
        if($area === NULL)
            throw new ValidationException(self::MESSAGES['AREA_NOT_VALID'], ValidationException::VALUE_IS_NULL);

        return TRUE;
    }

    /**
     * @param string|null $content
     * @return bool
     * @throws ValidationException
     */
    public static function validateContent(?string $content): bool
    {
        if($content === NULL)
            throw new ValidationException(self::MESSAGES['CONTENT_NOT_VALID'], ValidationException::VALUE_IS_NULL);

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
            throw new ValidationException(self::MESSAGES['WEIGHT_NOT_VALID'], ValidationException::VALUE_IS_NULL);

        return TRUE;
    }
}