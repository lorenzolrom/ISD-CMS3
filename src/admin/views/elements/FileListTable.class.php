<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:27 PM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use admin\views\content\ListTableFileItem;
use files\FileLister;

class FileListTable extends AdminView
{
    /**
     * FileListTable constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $this->setTemplateFromHTML("ListTable", self::ADMIN_TEMPLATE_ELEMENT);

        $rowString = "";

        foreach(FileLister::getUploadedFileList() as $file)
        {
            $item = new ListTableFileItem($file);
            $rowString .= $item->getHTML();
        }

        $this->setVariable("bodyContent", $rowString);
        $this->setVariable("headerContent", "<th>File Name</th>\n");
    }
}