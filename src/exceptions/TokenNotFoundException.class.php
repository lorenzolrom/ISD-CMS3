<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/25/2019
 * Time: 7:32 PM
 */


namespace exceptions;


class TokenNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => 'Token not found.'
    );
}