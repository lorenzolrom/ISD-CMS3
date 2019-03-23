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

use database\PostCategoryDatabaseHandler;
use database\PostDatabaseHandler;
use exceptions\PostCategoryNotFoundException;
use exceptions\PostNotFoundException;
use views\pages\AllPostsPage;
use views\pages\PostCategoryNotFoundPage;
use views\pages\PostCategoryPage;
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
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws PostNotFoundException
     */
    public function getPage(): string
    {
        $uriParts = explode('/', $this->uri);
        $route = array_shift($uriParts); // Get first part of request

        switch($route)
        {
            case "posts":
                return $this->processPostRequest($uriParts);
                break;
            case "category":
                return $this->processPostCategoryRequest($uriParts);
                break;
            default:
                throw new PostNotFoundException(PostNotFoundException::MESSAGES[PostNotFoundException::PRIMARY_KEY_NOT_FOUND], PostNotFoundException::PRIMARY_KEY_NOT_FOUND);
        }
    }

    /**
     * @param array $uriParts
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\PostCategoryNotFoundException
     * @throws \exceptions\ViewException
     */
    private function processPostRequest(array $uriParts): string
    {
        try
        {
            if (empty($uriParts))
            {
                $page = new AllPostsPage();
                return $page->getHTML();
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

    /**
     * @param array $uriParts
     * @return string
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     * @throws PostNotFoundException
     */
    private function processPostCategoryRequest(array $uriParts): string
    {
        try
        {
            if(sizeof($uriParts) == 1)
            {
                $category = PostCategoryDatabaseHandler::selectById(intval(array_shift($uriParts)));

                $page = new PostCategoryPage($category);
                return $page->getHTML();
            }
            else
            {
                throw new PostCategoryNotFoundException(PostCategoryNotFoundException::MESSAGES[PostCategoryNotFoundException::PRIMARY_KEY_NOT_FOUND], PostCategoryNotFoundException::PRIMARY_KEY_NOT_FOUND);
            }
        }
        catch(PostCategoryNotFoundException $e)
        {
            $page = new PostCategoryNotFoundPage($e);
            return $page->getHTML();
        }
    }
}