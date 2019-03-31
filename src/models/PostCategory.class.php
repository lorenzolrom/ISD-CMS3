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

use exceptions\ValidationException;

/**
 * Class PostCategory
 *
 * A category that contains posts
 *
 * @package models
 */
class PostCategory
{
    const FIELDS = array('title', 'previewImage', 'displayed');
    const MESSAGES = array(
        'TITLE_LENGTH_ERROR' => 'Title Must Be Between 1 And 64 Characters',
        'TITLE_NOT_VALID' => "Name Must Contain Only Letters, Numbers, '.', '&', or '-'",
        'PREVIEW_IMAGE_REQUIRED' => 'Preview Image Required',
        'DISPLAYED_NOT_VALID' => 'Displayed Not Valid'
    );

    private $id;
    private $title;
    private $previewImage;
    private $displayed;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPreviewImage(): string
    {
        return $this->previewImage;
    }

    /**
     * @return string
     */
    public function getDisplayed(): string
    {
        return $this->displayed;
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
     * @param string|null $previewImage
     * @return bool
     * @throws ValidationException
     */
    public static function validatePreviewImage(?string $previewImage): bool
    {
        if($previewImage === NULL)
            throw new ValidationException(self::MESSAGES['PREVIEW_IMAGE_REQUIRED'], ValidationException::VALUE_IS_NULL);
        else if(strlen($previewImage) < 1)
            throw new ValidationException(self::MESSAGES['PREVIEW_IMAGE_REQUIRED'], ValidationException::VALUE_TOO_SHORT);

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
}