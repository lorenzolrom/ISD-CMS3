<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 7:06 PM
 */


namespace exceptions;


class SecurityException extends \Exception
{
    const USERNAME_NOT_FOUND = 501;
    const PASSWORD_IS_WRONG = 502;
    const USER_NOT_LOGGED_IN = 503;
    const TOKEN_NOT_VALID = 504;
    const TOKEN_EXPIRED = 505;
    const USER_DOES_NOT_HAVE_REQUIRED_ROLE = 506;

    const MESSAGE = array(
        self::USERNAME_NOT_FOUND => 'Username or Password is Incorrect',
        self::PASSWORD_IS_WRONG => 'Username or Password is Incorrect',
        self::USER_NOT_LOGGED_IN => 'Please Sign In',
        self::TOKEN_NOT_VALID => 'Please Sign In',
        self::TOKEN_EXPIRED => 'Session Expired',
        self::USER_DOES_NOT_HAVE_REQUIRED_ROLE => 'You Do Not Have Permission to View This Page'
    );
}