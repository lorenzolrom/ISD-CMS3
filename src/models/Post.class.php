<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:12 PM
 */


namespace models;

use database\PostCategoryDatabaseHandler;
use exceptions\PostCategoryNotFoundException;
use exceptions\ValidationException;

/**
 * Class Post
 *
 * A text "blog" post with a featured image
 *
 * @package models
 */
class Post
{
    const FIELDS = array('title', 'date', 'category', 'previewImage', 'displayed', 'featured', 'content');

    const MESSAGES = array(
        'CATEGORY_NOT_VALID' => "Category Not Valid",
        'DATE_NOT_VALID' => "Date Not Valid",
        'TITLE_LENGTH_ERROR' => "Title Must Be Between 1 and 64 Characters",
        'TITLE_NOT_VALID' => "Name Must Contain Only Letters, Numbers, '.', '&', or '-'",
        'CONTENT_REQUIRED' => "Content Required",
        'DISPLAYED_NOT_VALID' => "Displayed Not Valid",
        'FEATURED_NOT_VALID' => "Featured Not Valid",
    );

    private $id;
    private $category;
    private $author;
    private $date;
    private $title;
    private $content;
    private $previewImage;
    private $displayed;
    private $featured;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return PostCategory|null
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     */
    public function getCategoryObject(): ?PostCategory
    {
        if($this->category === NULL)
            return NULL;

        return PostCategoryDatabaseHandler::selectById($this->category);
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
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getPreviewImage(): ?string
    {
        return $this->previewImage;
    }

    /**
     * @return int
     */
    public function getDisplayed(): int
    {
        return $this->displayed;
    }

    /**
     * @return int
     */
    public function getFeatured(): int
    {
        return $this->featured;
    }

    /**
     * @param int|null $category
     * @return bool
     * @throws ValidationException
     * @throws \exceptions\DatabaseException
     */
    public static function validateCategory(?int $category): bool
    {
        if($category !== NULL)
        {
            try
            {
                PostCategoryDatabaseHandler::selectById($category);
            }
            catch (PostCategoryNotFoundException $e)
            {
                throw new ValidationException(self::MESSAGES['CATEGORY_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);
            }
        }

        return TRUE;
    }

    /**
     * @param string|null $date
     * @return bool
     * @throws ValidationException
     */
    public static function validateDate(?string $date): bool
    {
        if($date === NULL)
            throw new ValidationException(self::MESSAGES['DATE_NOT_VALID'], ValidationException::VALUE_IS_NULL);
        else if(!ValidationException::validDate($date))
            throw new ValidationException(self::MESSAGES['DATE_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

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
        else if(!preg_match("/^[A-Za-z0-9.&\-\s\/]+$/",$title))
            throw new ValidationException(self::MESSAGES['TITLE_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

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
            throw new ValidationException(self::MESSAGES['CONTENT_REQUIRED'], ValidationException::VALUE_IS_NULL);
        else if(strlen($content) < 1)
            throw new ValidationException(self::MESSAGES['CONTENT_REQUIRED'], ValidationException::VALUE_TOO_SHORT);

        return TRUE;
    }

    /**
     * @param int|null $displayed
     * @return bool
     * @throws ValidationException
     */
    public static function validateDisplayed(?int $displayed): bool
    {
        if($displayed === NULL)
            throw new ValidationException(self::MESSAGES['DISPLAYED_NOT_VALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($displayed, array(0, 1)))
            throw new ValidationException(self::MESSAGES['DISPLAYED_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }

    /**
     * @param int|null $featured
     * @return bool
     * @throws ValidationException
     */
    public static function validateFeatured(?int $featured): bool
    {
        if($featured === NULL)
            throw new ValidationException(self::MESSAGES['FEATURED_NOT_VALID'], ValidationException::VALUE_IS_NULL);
        else if(!in_array($featured, array(0, 1)))
            throw new ValidationException(self::MESSAGES['FEATURED_NOT_VALID'], ValidationException::VALUE_IS_NOT_VALID);

        return TRUE;
    }
}