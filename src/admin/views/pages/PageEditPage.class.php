<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 10:55 PM
 */


namespace admin\views\pages;


use admin\views\forms\PageForm;
use models\Page;

class PageEditPage extends FormDocument
{
    public function __construct(Page $page)
    {
        parent::__construct(new PageForm($page), array('editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Page: " . $page->getUri());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}pages/view/{$page->getId()}");
    }
}