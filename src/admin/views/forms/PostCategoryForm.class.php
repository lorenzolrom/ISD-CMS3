<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 7:34 AM
 */


namespace admin\views\forms;

use exceptions\ValidationException;
use files\FileLister;
use models\PostCategory;

class PostCategoryForm extends Form
{
    /**
     * PostCategoryForm constructor.
     * @param PostCategory|null $category
     * @throws \exceptions\ViewException
     */
    public function __construct(?PostCategory $category = NULL)
    {
        $this->setTemplateFromHTML("PostCategoryForm", self::ADMIN_TEMPLATE_FORM);

        if($category !== NULL)
        {
            $this->setVariable("title", htmlentities($category->getTitle()));

            // Generate Preview Image List
            $previewImageSelect = "";

            foreach(FileLister::getUploadedFilesByType(FileLister::FILETYPE_IMAGE) as $image)
            {
                if(($category !== NULL AND $category->getPreviewImage() == $image) OR (isset($_POST['previewImage']) AND $_POST['previewImage'] == $image))
                    $selected = self::SELECTED;
                else
                    $selected = "";

                $previewImageSelect .= "<option value='$image' $selected>$image</option>\n";
            }

            if($category->getDisplayed() == 0)
                $this->setVariable("displayedNo", self::SELECTED);

            $this->setVariable("previewImageSelect", $previewImageSelect);
        }
    }

    /**
     * Selected correct DISPLAYED value
     * @return string
     */
    public function getHTML(): string
    {
        if(isset($_POST['displayed']) AND $_POST['displayed'] == 0)
            $this->setVariable("displayedNo", self::SELECTED);

        return parent::getHTML();
    }

    /**
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(PostCategory::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $field)
        {
            $fields[$field] = $_POST[$field];
        }

        try
        {
            PostCategory::validateTitle($fields['title']);
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
            PostCategory::validateDisplayed((int)$fields['displayed']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}