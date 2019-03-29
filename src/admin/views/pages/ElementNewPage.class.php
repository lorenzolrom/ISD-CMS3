<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 12:03 PM
 */


namespace admin\views\pages;


use admin\views\forms\ElementForm;
use models\Page;

class ElementNewPage extends UserDocument
{
    public function __construct(Page $page)
    {
        parent::__construct(array('editor', 'administrator'));

        $this->setVariable("tabTitle", "New Element");

        $form = new ElementForm($page);
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}pages/view/{$page->getId()}");
    }
}