<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:15 PM
 */


namespace models;

use database\ElementDatabaseHandler;
use database\PageDatabaseHandler;
use exceptions\ValidationException;

/**
 * Class Page
 * @package models
 */
class Page
{
    // Valid page types
    const TYPES = array('Basic', 'No Title', 'Home');

    const FIELDS = array('type', 'uri', 'title', 'navTitle', 'isOnNav', 'weight', 'protected', 'previewImage');

    const MESSAGES = array(
        'TYPE_INVALID' => 'Type Not Valid',
        'URI_LENGTH_ERROR' => 'URI Must Be Between 0 And 255 Characters',
        'URI_INVALID_ERROR' => "URI Must Only Contain Letters, Numbers, '-', '_', and '/'",
        'URI_ALREADY_IN_USE' => 'URI Already Taken',
        'TITLE_LENGTH_ERROR' => 'Title Must Be Between 1 And 64 Characters',
        'NAV_TITLE_LENGTH_ERROR' => 'Nav Title Must Be Between 1 and 64 Characters',
        'IS_ON_NAV_NOT_VALID' => 'Is On Nav Not Valid',
        'WEIGHT_NOT_VALID' => 'Weight Must Be An Integer',
        'PROTECTED_NOT_VALID' => 'Protected Not Valid'
    );

    private $id;
    private $type;
    private $author;
    private $uri;
    private $title;
    private $navTitle;
    private $previewImage;
    private $isOnNav;
    private $weight;
    private $protected;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getAuthor(): ?int
    {
        return $this->author;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getNavTitle(): ?string
    {
        return $this->navTitle;
    }

    /**
     * @return string|null
     */
    public function getPreviewImage(): ?string
    {
        return $this->previewImage;
    }


    /**
     * @return mixed
     */
    public function getIsOnNav()
    {
        return $this->isOnNav;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public function getProtected(): int
    {
        return $this->protected;
    }

    /**
     * @return Element[]
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     */
    public function getElements(): array
    {
        return ElementDatabaseHandler::selectByPage($this->id);
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
     * @param string|null $uri
     * @return bool
     * @throws ValidationException
     */
    public static function validateURI(?string $uri): bool
    {
        if($uri === NULL)
            throw new ValidationException(self::MESSAGES['URI_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($uri) > 255)
            throw new ValidationException(self::MESSAGES['URI_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if($uri != "" AND !preg_match("/^[A-Za-z0-9\_\-\s\/]+$/",$uri)) // Valid URL
            throw new ValidationException(self::MESSAGES['URI_INVALID_ERROR'], ValidationException::VALUE_IS_NOT_VALID);
        else if(PageDatabaseHandler::uriInUse($uri))
            throw new ValidationException(self::MESSAGES['URI_ALREADY_IN_USE'], ValidationException::VALUE_ALREADY_TAKEN);

        return TRUE;
    }

    /**
     * @param string|null $title
     * @return bool
     * @throws ValidationException
     */
    public static function validateTitle(?string $title): bool
    {
        if($title === NULL)
            throw new ValidationException(self::MESSAGES['TITLE_LENGTH_ERROR'], ValidationException::VALUE_IS_NULL);
        else if(strlen($title) < 1)
            throw new ValidationException(self::MESSAGES['TITLE_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($title) > 64)
            throw new ValidationException(self::MESSAGES['TITLE_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);

        return TRUE;
    }

    /**
     * @param string|null $navTitle
     * @return bool
     * @throws ValidationException
     */
    public static function validateNavTitle(?string $navTitle): bool
    {
        // nav title is optional
        if($navTitle === NULL OR strlen($navTitle) == 0)
            return TRUE;
        else if(strlen($navTitle) < 1)
            throw new ValidationException(self::MESSAGES['NAV_TITLE_LENGTH_ERROR'], ValidationException::VALUE_TOO_SHORT);
        else if(strlen($navTitle) > 64)
            throw new ValidationException(self::MESSAGES['NAV_TITLE_LENGTH_ERROR'], ValidationException::VALUE_TOO_LONG);

        return TRUE;
    }

    /**
     * @param int|null $isOnNav
     * @return bool
     * @throws ValidationException
     */
    public static function validateIsOnNav(?int $isOnNav): bool
    {
        if($isOnNav === NULL)
            throw new ValidationException(self::MESSAGES['IS_ON_NAV_NOT_VALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($isOnNav, array(0, 1)))
            throw new ValidationException(self::MESSAGES['IS_ON_NAV_NOT_VALID'], ValidationException::VALUE_IS_NULL);

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

    /**
     * @param int|null $protected
     * @return bool
     * @throws ValidationException
     */
    public static function validateProtected(?int $protected): bool
    {
        if($protected === NULL)
            throw new ValidationException(self::MESSAGES['PROTECTED_NOT_VALID'], ValidationException::VALUE_IS_NULL);

        return TRUE;
    }
}