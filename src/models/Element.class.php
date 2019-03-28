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

class Element
{
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
}