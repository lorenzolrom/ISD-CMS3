<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 12:08 PM
 */


namespace exceptions;


class PageParameterException extends \Exception
{
    const PARAMETER_NOT_SUPPLIED = 901;

    const MESSAGES = array(
        self::PARAMETER_NOT_SUPPLIED => "Parameter Not Supplied"
    );
}