<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 7:37 AM
 */


namespace admin\views\pages;


use admin\views\forms\PostCategoryForm;

class PostCategoryNewPage extends FormDocument
{
    /**
     * PostCategoryNewPage constructor.
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(new PostCategoryForm(), array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "New Category");
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}categories");
    }
}