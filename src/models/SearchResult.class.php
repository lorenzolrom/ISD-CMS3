<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:46 AM
 */


namespace models;

/**
 * Class SearchResult
 *
 * Container for results of a search
 *
 * @package models
 */
class SearchResult
{
    private $resultCount;
    private $results;

    /**
     * SearchResult constructor.
     * @param array $results
     */
    public function __construct(array $results)
    {
        $this->resultCount = sizeof($results['posts']) + sizeof($results['pages']);
        $this->results = $results;
    }

    /**
     * @return int
     */
    public function getResultCount(): int
    {
        return $this->resultCount;
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return Post[]
     */
    public function getPostResults(): array
    {
        return $this->results['posts'];
    }

    /**
     * @return array[]
     */
    public function getPageResults(): array
    {
        return $this->results['pages'];
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->results['query'];
    }
}