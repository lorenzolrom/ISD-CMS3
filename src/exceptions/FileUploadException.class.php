<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 1:04 PM
 */


namespace exceptions;


class FileUploadException extends \Exception
{
    const FILE_UPLOAD_FAILED = 1001;
    const FILE_ALREADY_EXISTS = 1002;
    const FILE_NOT_FOUND = 1003;

    const MESSAGES = array(
        self::FILE_UPLOAD_FAILED => 'File Upload Failed',
        self::FILE_ALREADY_EXISTS => 'File Already Exists and Override Not Selected',
        self::FILE_NOT_FOUND => 'File Not Found'
    );
}