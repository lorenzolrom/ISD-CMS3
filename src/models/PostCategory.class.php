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

/**
 * Class PostCategory
 *
 * A category that contains posts
 *
 * @package models
 */
class PostCategory
{
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
}