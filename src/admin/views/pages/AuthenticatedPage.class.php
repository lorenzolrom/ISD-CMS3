<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 5:16 PM
 */


namespace admin\views\pages;

use admin\controllers\SessionValidationController;
use admin\views\AdminView;

/**
 * Class AuthenticatedPage
 *
 * A page that requires the user to be signed in
 *
 * @package admin\views\pages
 */
class AuthenticatedPage extends AdminView
{
    public function __construct()
    {
        SessionValidationController::validateSession();
    }
}