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
 * Class Post
 *
 * A text "blog" post with a featured image
 *
 * @package models
 */
class Post
{
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @param int|null $category
     */
    public function setCategory(?int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int|null
     */
    public function getAuthor(): ?int
    {
        return $this->author;
    }

    /**
     * @param int|null $author
     */
    public function setAuthor(?int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPreviewImage(): string
    {
        return $this->previewImage;
    }

    /**
     * @param string $previewImage
     */
    public function setPreviewImage(string $previewImage): void
    {
        $this->previewImage = $previewImage;
    }

    /**
     * @return int
     */
    public function getDisplayed(): int
    {
        return $this->displayed;
    }

    /**
     * @param int $displayed
     */
    public function setDisplayed(int $displayed): void
    {
        $this->displayed = $displayed;
    }

    /**
     * @return int
     */
    public function getFeatured(): int
    {
        return $this->featured;
    }

    /**
     * @param int $featured
     */
    public function setFeatured(int $featured): void
    {
        $this->featured = $featured;
    }


}