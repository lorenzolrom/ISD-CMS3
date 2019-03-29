<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 10:45 PM
 */


namespace admin\views\pages;


use admin\views\forms\PostForm;
use models\Post;

class PostEditPage extends UserDocument
{
    /**
     * PostEditPage constructor.
     * @param Post $post
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\SecurityException
     * @throws \exceptions\ViewException
     */
    public function __construct(Post $post)
    {
        parent::__construct(array('editor', 'author', 'administrator'));

        $this->setVariable("tabTitle", "Edit Post: " . $post->getTitle());

        $form = new PostForm($post);
        $this->setVariable("mainContent", $form->getHTML());

        $this->setVariable("cancelURI", "{{@baseURI}}{{@adminURI}}posts");
    }
}