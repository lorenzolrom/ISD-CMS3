<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 3:30 PM
 */


namespace admin\controllers;

abstract class Controller extends \controllers\Controller
{
    protected $uriParts;

    public function __construct(array $uriParts, string $uri = "")
    {
        parent::__construct($uri);
        $this->uriParts = $uriParts;
    }
}