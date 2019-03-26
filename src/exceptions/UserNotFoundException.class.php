<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 7:03 PM
 */


namespace exceptions;


class UserNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => 'User Not Found',
        self::UNIQUE_KEY_NOT_FOUND => 'User Not Found'
    );
}