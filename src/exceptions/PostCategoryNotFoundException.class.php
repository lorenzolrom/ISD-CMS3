<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:20 PM
 */


namespace exceptions;


class PostCategoryNotFoundException extends EntryNotFoundException
{
    const MESSAGES = array(
        self::PRIMARY_KEY_NOT_FOUND => "Category Not Found"
    );
}