<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 11:02 AM
 */


namespace views\elements;


use views\content\PostSearchResult;
use views\View;

class PostSearchResultList extends View
{
    /**
     * PostSearchResultList constructor.
     * @param array $postResults
     * @throws \exceptions\ViewException
     */
    public function __construct(array $postResults)
    {
        $this->setTemplateFromHTML("SearchResultList", self::TEMPLATE_ELEMENT);
        $this->setVariable("resultType", "Projects");

        $resultList = "";

        foreach($postResults as $post)
        {
            $result = new PostSearchResult($post);
            $resultList .= $result->getHTML();
        }

        $this->setVariable("resultList", $resultList);
    }
}