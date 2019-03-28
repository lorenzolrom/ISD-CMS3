<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 5:34 PM
 */


namespace exceptions;


class ValidationException extends \Exception
{
    const VALUE_IS_OK = 0;
    const VALUE_TOO_SHORT = 1;
    const VALUE_TOO_LONG = 2;
    const VALUE_ALREADY_TAKEN = 3;
    const VALUE_IS_NULL = 4;
    const VALUE_IS_NOT_VALID = 5;
}