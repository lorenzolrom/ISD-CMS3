<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 7:42 PM
 */


namespace admin\views\pages;


use admin\views\forms\DoorwayForm;
use models\Doorway;

class DoorwayEditPage extends FormDocument
{
    public function __construct(Doorway $doorway)
    {
        parent::__construct( new DoorwayForm($doorway), array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Doorway: " . $doorway->getUri());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}doorways");
    }
}