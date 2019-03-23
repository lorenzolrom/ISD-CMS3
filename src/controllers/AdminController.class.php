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
 * Class AdminController
 * @package controllers
 */
class AdminController extends Controller
{

    public function getPage(): string
    {
        return "Admin";
    }
}