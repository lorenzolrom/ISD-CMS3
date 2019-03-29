<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:43 PM
 */


namespace admin\views\pages;


use admin\views\forms\FileForm;

class FileUploadPage extends UserDocument
{
    public function __construct()
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Upload File");

        $form = new FileForm();
        $this->setVariable("mainContent", $form->getHTML());
    }
}