<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 2:56 PM
 */


namespace admin\views\content;


use admin\views\AdminView;

class ListTableItem extends AdminView
{
    /**
     * ListTableItem constructor.
     * @param mixed $id Unique identifier for this row
     * @param array $cells
     * @throws \exceptions\ViewException
     */
    public function __construct($id, array $cells)
    {
        $this->setTemplateFromHTML("ListTableItem", self::ADMIN_TEMPLATE_CONTENT);

        $cellString = "";

        foreach($cells as $cell)
        {
            $cellString .= "<td>" . htmlentities($cell) . "</td>\n";
        }

        $this->setVariable("id", $id); // Set the unique identifier for item represented by this row
        $this->setVariable("itemContent", $cellString);
    }
}