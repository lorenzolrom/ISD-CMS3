<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 5:11 PM
 */


namespace admin\controllers;


use admin\views\pages\Dashboard;

class DashboardController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        $page = new Dashboard();
        return $page->getHTML();
    }
}