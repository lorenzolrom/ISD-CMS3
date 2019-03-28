<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 2:52 PM
 */


namespace admin\views\elements;


use admin\views\AdminView;
use admin\views\content\ListTableItem;

abstract class ListTable extends AdminView
{
    protected $itemURI;

    /**
     * ListTable constructor.
     * @param string $itemURI URI to the resource this is listing
     * @param array $rows array of items to display in the list
     * @throws \exceptions\ViewException
     */
    public function __construct(string $itemURI, array $rows)
    {
        $this->itemURI = $itemURI;
        $this->setTemplateFromHTML("ListTable", self::ADMIN_TEMPLATE_ELEMENT);

        $rowString = "";

        foreach($rows as $row)
        {
            $item = new ListTableItem($row['id'], $row['cells']);
            $rowString .= $item->getTemplate();
        }

        $this->setVariable("bodyContent", $rowString);
    }

    /**
     * Set the resource URI
     *
     * @return string
     * @throws \exceptions\ViewException
     */
    public function getHTML(): string
    {
        $this->setVariable("itemURI", $this->itemURI);
        return parent::getHTML();
    }

    /**
     * @param array $headers
     */
    protected function setHeader(array $headers)
    {
        $headerString = "<th>ID</th>\n";

        foreach($headers as $header)
        {
            $headerString .= "<th>$header</th>\n";
        }

        $this->setVariable("headerContent", $headerString);

    }
}