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
     * @return mixed
     */
    public function getNavTitle()
    {
        return $this->navTitle;
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
     * @return Element[]
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     */
    public function getElements(): array
    {
        return ElementDatabaseHandler::selectByPage($this->id);
    }
}