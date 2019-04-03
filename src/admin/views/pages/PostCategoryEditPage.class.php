<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 9:18 AM
 */


namespace admin\views\pages;


use admin\views\forms\PostCategoryForm;
use models\PostCategory;

class PostCategoryEditPage extends FormDocument
{
    /**
     * PostCategoryEditPage constructor.
     * @param PostCategory $category
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(PostCategory $category)
    {
        parent::__construct(new PostCategoryForm($category), array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Category: " . $category->getTitle());
        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}categories");
    }
}