<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 8:59 AM
 */


namespace exceptions;


class SearchException extends \Exception
{
    const QUERY_NOT_SUPPLIED = 401;
    const QUERY_TOO_SHORT = 402;
    const NO_RESULTS = 403;

    const MESSAGES = array(
        self::QUERY_NOT_SUPPLIED => "No query supplied.",
        self::QUERY_TOO_SHORT => "Query must be at least 3 characters.",
        self::NO_RESULTS => "Query produced no results."
    );
}