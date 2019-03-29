<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:43 AM
 */


namespace admin\views\elements;


use database\ContentDatabaseHandler;
use models\Element;

class ContentListTable extends ListTable
{
    /**
     * ContentListTable constructor.
     * @param Element $element
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\ViewException
     */
    public function __construct(Element $element)
    {
        $rows = array();

        foreach(ContentDatabaseHandler::selectByElement($element->getId()) as $content)
        {
            $rows[] = array(
                'id' => $content->getId(),
                'cells' => array(
                    'name' => $content->getName(),
                    'area' => $content->getArea(),
                    'weight' => $content->getWeight()
                )
            );
        }

        parent::__construct("content", $rows);
        $this->setHeader(array('Name', 'Area', 'Weight'));
    }
}