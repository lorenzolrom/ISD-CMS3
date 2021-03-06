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
use exceptions\SecurityException;
use models\User;

/**
 * Class AuthenticatedPage
 *
 * A page that requires the user to be signed in
 *
 * @package admin\views\pages
 */
class AuthenticatedPage extends AdminView
{
    protected $user;

    /**
     * AuthenticatedPage constructor.
     * @param array|null $roles Roles to evaluate.  Optional.
     * @throws SecurityException
     */
    public function __construct(?array $roles = NULL)
    {
        $this->user = SessionValidationController::validateSession();

        // If role requirements were set, validate them
        if($roles !== NULL)
        {
            self::validateRoles($this->user, $roles);
        }
    }

    /**
     * @param User $user
     * @param array $roles
     * @return bool
     * @throws SecurityException
     */
    public static function validateRoles(User $user, array $roles): bool
    {
        if(!in_array($user->getRole(), $roles))
        {
            throw new SecurityException(SecurityException::MESSAGE[SecurityException::USER_DOES_NOT_HAVE_REQUIRED_ROLE], SecurityException::USER_DOES_NOT_HAVE_REQUIRED_ROLE);
        }

        return TRUE;
    }
}