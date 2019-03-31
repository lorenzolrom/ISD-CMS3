<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/31/2019
 * Time: 11:49 AM
 */


namespace files;


class FileLister
{
    const FILETYPE_IMAGE = array(
        'png', 'gif', 'jpg', 'jpeg', 'bmp', 'svg', 'ico'
    );

    /**
     * @return array
     */
    public static function getUploadedFileList(): array
    {
        $files = array();

        foreach(scandir(dirname(__FILE__) . "/../public/site/files") as $file)
        {
            if(!in_array($file, array('.', '..')))
                $files[] = $file;
        }

        return $files;
    }

    /**
     * Retrieve a list of files matching the specified types
     * @param array $fileTypes
     * @return array
     */
    public static function getUploadedFilesByType(array $fileTypes): array
    {
        $images = array();

        foreach(self::getUploadedFileList() as $file)
        {
            // Check file extension
            $fileNameParts = explode('.', $file);
            if(in_array(strtolower($fileNameParts[sizeof($fileNameParts) - 1]), $fileTypes))
            {
                $images[] = $file;
            }
        }

        return $images;
    }
}