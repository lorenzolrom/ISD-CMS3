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
     * @param string $itemURI
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\DoorwayNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(string $itemURI)
    {
        $rows = array();

        foreach(DoorwayDatabaseHandler::select() as $doorway)
        {
            $rows[] = array(
                'id' => $doorway->getId(),
                'cells' => array(
                    'uri' => $doorway->getUri(),
                    'destination' => $doorway->getDestination()
                )
            );
        }

        parent::__construct($itemURI, $rows);
        $this->setHeader(array('URI', 'Destination'));
    }
}