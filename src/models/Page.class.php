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

/**
 * Class Page
 * @package models
 */
class Page
{
    private $id;
    private $type;
    private $author;
    private $uri;
    private $title;
    private $navTitle;
    private $isOnNav;

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
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
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
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
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
     * @return mixed
     */
    public function getNavTitle()
    {
        return $this->navTitle;
    }

    /**
     * @param mixed $navTitle
     */
    public function setNavTitle($navTitle): void
    {
        $this->navTitle = $navTitle;
    }

    /**
     * @return mixed
     */
    public function getisOnNav()
    {
        return $this->isOnNav;
    }

    /**
     * @param mixed $isOnNav
     */
    public function setIsOnNav($isOnNav): void
    {
        $this->isOnNav = $isOnNav;
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
}