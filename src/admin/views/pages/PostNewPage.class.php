<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 9:08 PM
 */


namespace admin\views\pages;


use admin\views\forms\PostForm;

class PostNewPage extends UserDocument
{
    /**
     * PostNewPage constructor.
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        parent::__construct(array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "New Post");

        $form = new PostForm();

        $this->setVariable("mainContent", $form->getHTML());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}posts");
    }
}