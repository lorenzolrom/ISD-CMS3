<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 7:05 AM
 */


namespace admin\views\elements;


use database\ElementDatabaseHandler;
use models\Page;

class ElementListTable extends ListTable
{
    /**
     * ElementListTable.class constructor.
     * @param Page $page
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ElementNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page)
    {
        $rows = array();

        foreach(ElementDatabaseHandler::selectByPage($page->getId()) as $element)
        {
            $rows[] = array(
                'id' => $element->getId(),
                'cells' => array(
                    'name' => $element->getName(),
                    'type' => $element->getType(),
                    'weight' => $element->getWeight()
                )
            );
        }

        parent::__construct("elements", $rows, TRUE);
        $this->setHeader(array('Name', 'Type', 'Weight'));
    }
}