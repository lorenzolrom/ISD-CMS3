<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 9:20 AM
 */


namespace exceptions;


class PageNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Requested page was not found",
        self::UNIQUE_KEY_NOT_FOUND => "Requested page was not found"
    );
}