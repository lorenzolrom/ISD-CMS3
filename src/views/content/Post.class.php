<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 5:40 PM
 */


namespace views\content;

use views\View;

class Post extends View
{
    /**
     * Post constructor.
     * @param \models\Post $post
     * @throws \exceptions\ViewException
     */
    public function __construct(\models\Post $post)
    {
        $this->setTemplateFromHTML("Post", self::TEMPLATE_CONTENT);

        $this->setVariable("postTitle", $post->getTitle());
        $this->setVariable("postImgSrc", $post->getPreviewImage());
        $this->setVariable("postId", $post->getId());
    }
}