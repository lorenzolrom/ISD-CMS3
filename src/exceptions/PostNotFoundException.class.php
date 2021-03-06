<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:18 PM
 */


namespace exceptions;


class PostNotFoundException extends EntryNotFoundException
{
    public const POST_IS_DISABLED = 601;

    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Requested post was not found",
        self::POST_IS_DISABLED => "Requested post was not found"
    );
}