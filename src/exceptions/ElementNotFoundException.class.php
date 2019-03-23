<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:27 AM
 */


namespace exceptions;


class ElementNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Page Element Not Found",
        self::UNIQUE_KEY_NOT_FOUND => "Page Element Not Found"
    );
}