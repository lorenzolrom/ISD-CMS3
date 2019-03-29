<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:35 PM
 */


namespace admin\controllers;


use admin\views\pages\AuthenticatedPage;
use admin\views\pages\FileListPage;
use admin\views\pages\FileUploadPage;
use exceptions\FileUploadException;
use exceptions\PageNotFoundException;

class FileController extends Controller
{
    private $uploadPath;

    /**
     * @return string
     * @throws FileUploadException
     * @throws PageNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        $this->uploadPath = dirname(__FILE__) . "/../../public/site/files/";

        array_shift($this->uriParts);

        switch(array_shift($this->uriParts))
        {
            case null:
                $page = new FileListPage();
                return $page->getHTML();
                break;
            case "upload":
                return $this->uploadFile();
                break;
            case "delete":
                $this->deleteFile();
                return "";
                break;
            default:
                throw new PageNotFoundException(PageNotFoundException::MESSAGES[PageNotFoundException::PRIMARY_KEY_NOT_FOUND], PageNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @return string
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    private function uploadFile(): string
    {
        $page = new FileUploadPage();

        if(!empty($_FILES))
        {
            $file = basename($_FILES["upload"]["name"]);

            if(isset($_POST['override']))
                $override = TRUE;
            else
                $override = FALSE;

            if(!empty($file))
            {
                $target = $this->uploadPath . $file;

                try
                {
                    if(file_exists($target) AND !$override)
                    {
                        throw new FileUploadException(FileUploadException::MESSAGES[FileUploadException::FILE_ALREADY_EXISTS], FileUploadException::FILE_ALREADY_EXISTS);
                    }

                    if(!move_uploaded_file($_FILES["upload"]["tmp_name"], $target))
                        throw new FileUploadException(FileUploadException::MESSAGES[FileUploadException::FILE_UPLOAD_FAILED], FileUploadException::FILE_UPLOAD_FAILED);

                    header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "files?NOTICE=File Uploaded");
                    exit;
                }
                catch(FileUploadException $e)
                {
                    $page->setErrors(array($e->getMessage()));
                }
            }

        }

        return $page->getHTML();
    }

    /**
     * @throws FileUploadException
     * @throws \exceptions\SecurityException
     */
    private function deleteFile()
    {
        AuthenticatedPage::validateRoles(SessionValidationController::validateSession(), array('editor', 'administrator'));

        $file = $this->uploadPath . array_shift($this->uriParts);

        if(!file_exists($file))
            throw new FileUploadException(FileUploadException::MESSAGES[FileUploadException::FILE_NOT_FOUND], FileUploadException::FILE_NOT_FOUND);

        unlink($file);

        header("Location: " . \CMSConfiguration::CMS_CONFIG['baseURI'] . \CMSConfiguration::CMS_CONFIG['adminURI'] . "files?NOTICE=File Deleted");
        exit;
    }
}