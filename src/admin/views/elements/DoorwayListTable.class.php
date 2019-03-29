<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/26/2019
 * Time: 3:00 PM
 */


namespace admin\views\elements;


use database\DoorwayDatabaseHandler;

class DoorwayListTable extends ListTable
{
    /**
     * DoorwayListTable constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $rows = array();

        foreach(DoorwayDatabaseHandler::select() as $doorway)
        {
            $rows[] = array(
                'id' => $doorway->getId(),
                'cells' => array(
                    'uri' => htmlentities($doorway->getUri()),
                    'destination' => htmlentities($doorway->getDestination())
                )
            );
        }

        parent::__construct("doorways", $rows);
        $this->setHeader(array('URI', 'Destination'));
    }
}