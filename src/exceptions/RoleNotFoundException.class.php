<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 9:15 PM
 */


namespace exceptions;


class RoleNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Role Not Found"
    );
}