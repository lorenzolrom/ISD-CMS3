<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 9:00 PM
 */


namespace admin\views\forms;


use database\PostCategoryDatabaseHandler;
use models\Post;

class PostForm extends Form
{
    /**
     * PostForm constructor.
     * @param Post|null $post
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(?Post $post = NULL)
    {
        $this->setTemplateFromHTML("PostForm", self::ADMIN_TEMPLATE_FORM);

        // Fill in Post details
        if($post !== NULL)
        {
            $this->setVariable("title", htmlentities($post->getTitle()));
            $this->setVariable("date", $post->getDate());
            $this->setVariable("previewImage", htmlentities($post->getPreviewImage()));
            $this->setVariable("content", $post->getContent());

            if(!$post->getDisplayed())
                $this->setVariable("displayedNo", self::SELECTED);
            if($post->getFeatured())
                $this->setVariable("featuredYes", self::SELECTED);
        }

        // Generate Category List

        $categorySelect = "";

        foreach(PostCategoryDatabaseHandler::selectAll() as $category)
        {
            if(($post !== NULL AND $post->getCategory() == $category->getId()) OR (isset($_POST['category']) AND $_POST['category'] == $category->getId()))
                $selected = self::SELECTED;
            else
                $selected = "";

            $categorySelect .= "<option value='{$category->getId()}' $selected>{$category->getTitle()}</option>";
        }

        if(isset($_POST['displayed']) AND $_POST['displayed'] == 0)
            $this->setVariable("displayedNo", self::SELECTED);
        if(isset($_POST['featured']) AND $_POST['featured'] == 1)
            $this->setVariable("featuredYes", self::SELECTED);

        $this->setVariable("categorySelect", $categorySelect);
    }
}