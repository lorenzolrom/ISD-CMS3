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

class Content
{
    private $id;
    private $type;
    private $author;
    private $element;
    private $area;
    private $content;
    private $weight;
    private $classes;

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
    public function getType(): string
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
     * @return string|null
     */
    public function getClasses(): ?string
    {
        return $this->classes;
    }

}