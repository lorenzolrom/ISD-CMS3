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

use models\Page;
use models\Post;
use views\elements\Footer;
use views\elements\Header;
use views\View;

/**
 * Class PostPage
 *
 * Display a single post
 *
 * @package views\pages
 */
class PostPage extends HTML5Page
{
    /**
     * PostPage constructor.
     * @param Post $post
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Post $post)
    {
        parent::__construct();
        $this->setVariable("bodyContent", self::templateFileContents("CompleteSitePage", View::TEMPLATE_PAGE));

        // Load header and footer
        $header = new Header();
        $footer = new Footer();

        $this->setVariable("headerContent", $header->getHTML());
        $this->setVariable("footerContent", $footer->getHTML());

        // Load the post template
        $this->setVariable("mainContent", self::templateFileContents("PostPage", View::TEMPLATE_PAGE));

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
            // TODO: implement UserDatabaseHandler and get the author
            $this->setVariable("postAuthorName", "TBD");
        }
    }
}