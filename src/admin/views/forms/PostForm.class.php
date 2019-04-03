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
use exceptions\ValidationException;
use files\FileLister;
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

            $categorySelect .= "<option value='{$category->getId()}' $selected>{$category->getTitle()}</option>\n";
        }

        // Generate Preview Image List
        $previewImageSelect = "";

        foreach(FileLister::getUploadedFilesByType(FileLister::FILETYPE_IMAGE) as $image)
        {
            if(($post !== NULL AND $post->getPreviewImage() == $image) OR (isset($_POST['previewImage']) AND $_POST['previewImage'] == $image))
                $selected = self::SELECTED;
            else
                $selected = "";

            $previewImageSelect .= "<option value='$image' $selected>$image</option>\n";
        }

        if(isset($_POST['displayed']) AND $_POST['displayed'] == 0)
            $this->setVariable("displayedNo", self::SELECTED);
        if(isset($_POST['featured']) AND $_POST['featured'] == 1)
            $this->setVariable("featuredYes", self::SELECTED);

        $this->setVariable("categorySelect", $categorySelect);
        $this->setVariable("previewImageSelect", $previewImageSelect);
    }

    /**
     * @return array
     * @throws \exceptions\DatabaseException
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(Post::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $field)
        {
            $fields[$field] = $_POST[$field];
        }

        try
        {
            Post::validateTitle($fields['title']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Post::validateDate($fields['date']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            // Needed because no category is a valid option
            if($fields['category'] == "")
                $fields['category'] = NULL;
            else
                $fields['category'] = (int)$fields['category'];

            Post::validateCategory($fields['category']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        //Preview image
        if(!isset($_POST['previewImage']) OR strlen($_POST['previewImage']) == 0)
            $_POST['previewImage'] = NULL;

        try
        {
            Post::validateDisplayed((int)$fields['displayed']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Post::validateFeatured((int)$fields['featured']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}