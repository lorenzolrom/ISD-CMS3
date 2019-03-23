<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:18 AM
 */


namespace exceptions;


class EntryNotFoundException extends \Exception
{
    const PRIMARY_KEY_NOT_FOUND = 301;
    const UNIQUE_KEY_NOT_FOUND = 302;

    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Primary Key Not Found",
        self::UNIQUE_KEY_NOT_FOUND => "Unique Key Not Found"
    );
}