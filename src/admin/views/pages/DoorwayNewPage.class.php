<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 5:01 PM
 */


namespace admin\views\pages;


use admin\views\forms\DoorwayForm;

class DoorwayNewPage extends UserDocument
{
    /**
     * DoorwayNewPage constructor.
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "New Doorway");

        $form = new DoorwayForm();
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}doorways");
    }
}