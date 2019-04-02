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

        if($post->getPreviewImage() !== NULL)
            $this->setVariable("postImgSrc", "site/files/" . $post->getPreviewImage());
        else
            $this->setVariable("postImgSrc", "themes/" . \CMSConfiguration::CMS_CONFIG['theme'] . "/media/post.jpg");

        $this->setVariable("postId", $post->getId());
    }
}