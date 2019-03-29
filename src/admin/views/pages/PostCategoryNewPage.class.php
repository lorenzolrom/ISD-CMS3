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

class PostCategoryNewPage extends UserDocument
{
    /**
     * PostCategoryNewPage constructor.
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "New Category");

        $form = new PostCategoryForm();
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}categories");
    }
}