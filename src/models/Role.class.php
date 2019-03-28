<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:30 PM
 */


namespace models;


class Role
{
    private $code;
    private $displayName;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

}