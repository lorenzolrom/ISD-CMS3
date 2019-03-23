<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/23/2019
 * Time: 2:31 PM
 */


namespace controllers;

use database\PostDatabaseHandler;
use exceptions\PostNotFoundException;
use views\pages\PostNotFoundPage;
use views\pages\PostPage;

/**
 * Class PostController
 *
 * Handles displaying posts
 *
 * @package controllers
 */
class PostController extends Controller
{

    /**
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function getPage(): string
    {
        $uriParts = explode('/', $this->uri);
        array_shift($uriParts); // Remove 'posts'

        try
        {
            if (empty($uriParts))
            {
                return "All Posts";
            }
            else if (sizeof($uriParts) == 1)
            {
                $post = PostDatabaseHandler::selectById(intval(array_shift($uriParts)));
                $page = new PostPage($post);
                return $page->getHTML();
            }
            else
            {
                throw new PostNotFoundException(PostNotFoundException::MESSAGES[PostNotFoundException::PRIMARY_KEY_NOT_FOUND], PostNotFoundException::PRIMARY_KEY_NOT_FOUND);
            }
        }
        catch(PostNotFoundException $e)
        {
            $page = new PostNotFoundPage($e);
            return $page->getHTML();
        }
    }
}