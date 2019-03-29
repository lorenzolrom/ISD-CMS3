<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 12:28 PM
 */


namespace admin\views\content;


use admin\views\AdminView;

class ListTableFileItem extends AdminView
{
    /**
     * ListTableFileItem constructor.
     * @param string $fileName
     * @throws \exceptions\ViewException
     */
    public function __construct(string $fileName)
    {
        $this->setTemplateFromHTML("ListTableFileItem", self::ADMIN_TEMPLATE_CONTENT);

        $this->setVariable("fileName", $fileName);
        $this->setVariable("itemURI", "files");
    }
}