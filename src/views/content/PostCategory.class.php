<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 6:11 PM
 */


namespace views\content;


use views\View;

class PostCategory extends View
{
    /**
     * PostCategory constructor.
     * @param \models\PostCategory $category
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\PostCategory $category)
    {
        $this->setTemplateFromHTML("PostCategory", self::TEMPLATE_CONTENT);

        $this->setVariable("categoryTitle", $category->getTitle());

        if($category->getPreviewImage() !== NULL)
            $this->setVariable("categoryImgSrc", "site/files/" . $category->getPreviewImage());
        else
            $this->setVariable("categoryImgSrc", "themes/" . \CMSConfiguration::CMS_CONFIG['theme'] . "/media/post.jpg");

        $this->setVariable("categoryId", $category->getId());
    }
}