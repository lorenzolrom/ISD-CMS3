<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/28/2019
 * Time: 11:59 AM
 */


namespace admin\views\forms;


use exceptions\ValidationException;
use models\Element;
use models\Page;

class ElementForm extends Form
{
    /**
     * ElementForm constructor.
     * @param Page $page
     * @param Element|null $element
     * @throws \exceptions\ViewException
     */
    public function __construct(Page $page, ?Element $element = NULL)
    {
        $this->setTemplateFromHTML("ElementForm", self::ADMIN_TEMPLATE_FORM);

        // Set Page Info
        $this->setVariable("pageURI", $page->getUri());
        $this->setVariable("pageTitle", $page->getTitle());

        // Set Element Info (edit)
        if($element !== NULL)
        {
            $this->setVariable("name", $element->getName());
            $this->setVariable("weight", $element->getWeight());
        }

        $options = "";

        foreach(Element::TYPES as $type)
        {
            if(($element !== NULL AND $element->getType() == $type) OR (isset($_POST['type']) AND $_POST['type'] == $type))
                $selected = self::SELECTED;
            else
                $selected = "";

            $options .= "<option value='$type' $selected>$type</option>";
        }

        $this->setVariable("typeSelect", $options);
    }

    /**
     * Returns any validation errors encountered when the form is submitted
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(Element::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }

        // Name
        try
        {
            Element::validateName($fields['name']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Type
        try
        {
            Element::validateType($fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Weight
        try
        {
            Element::validateWeight((int)$fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}