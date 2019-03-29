<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:41 PM
 */


namespace views\pages;

use database\UserDatabaseHandler;
use models\Post;

/**
 * Class PostPage
 *
 * Display a single post
 *
 * @package views\pages
 */
class PostPage extends HeaderFooterPage
{
    /**
     * PostPage constructor.
     * @param Post $post
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     * @throws \exceptions\UserNotFoundException
     */
    public function __construct(Post $post)
    {
        parent::__construct();

        // Load the post template
        $this->setVariable("mainContent", self::templateFileContents("PostPage", self::TEMPLATE_PAGE));

        // Set post title
        $this->setVariable("tabTitle", $post->getTitle());
        $this->setVariable("pageTitle", $post->getTitle());
        $this->setVariable("postTitle", $post->getTitle());

        // Set post image
        $this->setVariable("postImgSrc", $post->getPreviewImage());

        // Set post content
        $this->setVariable("postContent", $post->getContent());

        // Set post author
        $this->setVariable("postDate", $post->getDate());

        if($post->getAuthor() === NULL)
            $this->setVariable("postAuthorName", "Anonymous");
        else
        {
            $author = UserDatabaseHandler::selectById($post->getAuthor());
            $this->setVariable("postAuthorName", $author->getName());
        }
    }
}