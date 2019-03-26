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

use admin\factories\ControllerFactory;

/**
 * Class AdminController
 * @package controllers
 */
class AdminController extends Controller
{

    public function getPage(): string
    {
        // Turn URI into array
        $uriParts = explode('/', $this->uri);
        array_shift($uriParts); // remove 'admin'

        return ControllerFactory::getController($uriParts)->getPage();
    }
}