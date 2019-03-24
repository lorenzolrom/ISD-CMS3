<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 11:05 AM
 */


namespace views\content;


use views\View;

class PostSearchResult extends View
{
    /**
     * PostSearchResult constructor.
     * @param \models\Post $post
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Post $post)
    {
        $this->setTemplateFromHTML("PostSearchResult", self::TEMPLATE_CONTENT);

        $this->setVariable("postTitle", $post->getTitle());
        $this->setVariable("postId", $post->getId());
        $this->setVariable("postImgSrc", $post->getPreviewImage());
    }
}