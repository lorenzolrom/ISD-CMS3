<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 9:45 PM
 */


namespace admin\views\pages;


use admin\views\forms\PageForm;

class PageNewPage extends FormDocument
{
    public function __construct()
    {
        parent::__construct(new PageForm(), array('editor', 'administrator'));

        $this->setVariable("tabTitle", "New Page");
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}pages");
    }
}