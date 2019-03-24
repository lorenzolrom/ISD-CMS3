<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/24/2019
 * Time: 11:09 AM
 */


namespace views\elements;


use views\content\PageSearchResult;
use views\View;

class PageSearchResultList extends View
{
    /**
     * PageSearchResultList constructor.
     * @param array $pageResults
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(array $pageResults)
    {
        $this->setTemplateFromHTML("SearchResultList", self::TEMPLATE_ELEMENT);
        $this->setVariable("resultType", "Pages");

        $resultList = "";

        foreach(array_keys($pageResults) as $pageURI)
        {
            $result = new PageSearchResult($pageURI, $pageResults[$pageURI]);
            $resultList .= $result->getHTML();
        }

        $this->setVariable("resultList", $resultList);
    }
}