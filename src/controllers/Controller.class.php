<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/12/2019
 * Time: 12:17 PM
 */


namespace controllers;

/**
 * Class Controller
 * @package controllers
 */
abstract class Controller
{
    protected $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    abstract public function getPage(): string;
}