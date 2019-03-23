<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:35 AM
 */


namespace exceptions;


class ContentNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Content Node Not Found",
        self::UNIQUE_KEY_NOT_FOUND => "Content Node Not Found"
    );
}