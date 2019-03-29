<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:33 PM
 */


namespace admin\views\pages;


use admin\views\elements\FileListTable;

class FileListPage extends UserDocument
{
    public function __construct()
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Files");

        $list = new FileListTable();

        $this->setVariable("mainContent", $list->getHTML());
        $this->setActionLinks(array(
            array(
                'title' => "Upload File",
                'href' => 'files/upload'
            )
        ));
    }
}