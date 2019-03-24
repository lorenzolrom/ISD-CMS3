<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:27 AM
 */


namespace exceptions;


class DoorwayNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Doorway not found.",
        self::UNIQUE_KEY_NOT_FOUND => "Doorway not found."
    );
}