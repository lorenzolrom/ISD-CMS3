<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:41 PM
 */


namespace admin\views\forms;


class FileForm extends Form
{
    const CHECKED = "checked";

    /**
     * FileForm constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $this->setTemplateFromHTML("FileForm", self::ADMIN_TEMPLATE_FORM);
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        if(isset($_POST['override']))
            $this->setVariable("checked", self::CHECKED);

        return parent::getHTML();
    }
}