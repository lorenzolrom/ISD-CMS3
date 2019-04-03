<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 5:45 PM
 */


namespace admin\views\forms;


use database\UserDatabaseHandler;
use exceptions\ValidationException;
use factories\ViewFactory;
use models\Content;
use models\Element;

class ContentForm extends Form
{
    /**
     * ContentForm constructor.
     * @param Element $element
     * @param Content|null $content
     * @throws \exceptions\ContentNotFoundException
     * @throws \exceptions\DatabaseException
     * @throws \exceptions\PageNotFoundException
     * @throws \exceptions\UserNotFoundException
     * @throws \exceptions\ViewException
     */
    public function __construct(Element $element, ?Content $content = NULL)
    {
        $this->setTemplateFromHTML("ContentForm", self::ADMIN_TEMPLATE_FORM);

        $page = $element->getPageObject();

        $this->setVariable("pageURI", $page->getUri());
        $this->setVariable("pageTitle", $page->getTitle());

        $this->setVariable("elementName", $element->getName());

        if($content !== NULL)
        {
            if($content->getAuthor() !== NULL)
            {
                $this->setVariable("author", UserDatabaseHandler::selectById($content->getAuthor())->getName());
            }

            $this->setVariable("weight", $content->getWeight());
            $this->setVariable("name", $content->getName());
            $this->setVariable("content", $content->getContent());
        }

        // Get element areas
        $view = ViewFactory::getElementView($element);

        $areaSelect = "";

        foreach($view->getAreas() as $area)
        {
            if((isset($_POST['area']) AND $_POST['area'] == $area) OR ($content !== NULL AND $content->getArea() == $area))
                $selected = self::SELECTED;
            else
                $selected = "";

            $areaSelect .= "<option value='$area' $selected>$area</option>";
        }

        $this->setVariable("areaSelect", $areaSelect);
    }

    /**
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(Content::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }

        try
        {
            Content::validateName($fields['name']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateArea($fields['area']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateWeight((int)$fields['weight']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Content::validateContent($fields['content']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}