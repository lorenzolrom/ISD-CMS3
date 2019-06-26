<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 6/26/2019
 * Time: 7:55 AM
 */


namespace models;


class ContactFormSubmission
{
    public const FIELDS = array('name', 'email', 'comments');

    const MESSAGES = array(
        'NAME_REQUIRED' => 'Name is required',
        'EMAIL_NOT_VALID' => 'Email is not valid',
        'COMMENT_REQUIRED' => 'Comment is required'
    );

    private $id;
    private $name;
    private $email;
    private $ipAddress;
    private $comment;
    private $time;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getTime(): string
    {
        return $this->time;
    }


}