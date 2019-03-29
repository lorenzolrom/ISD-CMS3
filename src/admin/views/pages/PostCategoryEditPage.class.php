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

class PostCategoryEditPage extends UserDocument
{
    public function __construct(PostCategory $category)
    {
        parent::__construct(array('author', 'editor', 'administrator'));

        $this->setVariable("tabTitle", "Edit Category: " . $category->getTitle());

        $form = new PostCategoryForm($category);
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}categories");
    }
}