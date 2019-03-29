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
            $this->setVariable("previewImage", htmlentities($category->getPreviewImage()));

            if($category->getDisplayed() == 0)
                $this->setVariable("displayedNo", self::SELECTED);
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
}