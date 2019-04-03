<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 9:36 PM
 */


namespace admin\views\forms;


use database\UserDatabaseHandler;
use exceptions\ValidationException;
use files\FileLister;
use models\Page;

class PageForm extends Form
{
    private $page;

    /**
     * PageForm constructor.
     * @param Page|null $page
     * @throws \exceptions\ViewException
     */
    public function __construct(?Page $page = NULL)
    {
        $this->page = $page;
        $this->setTemplateFromHTML("PageForm", self::ADMIN_TEMPLATE_FORM);

        if($page !== NULL)
        {
            $this->setVariable("uri", htmlentities($page->getUri()));
            $this->setVariable("title", htmlentities($page->getTitle()));
            $this->setVariable("navTitle", htmlentities($page->getNavTitle()));
            $this->setVariable("weight", $page->getWeight());

            if($page->getIsOnNav() == 0)
                $this->setVariable("isOnNavNo", self::SELECTED);
            if($page->getProtected() == 1)
                $this->setVariable("protectedYes", self::SELECTED);

            if($page->getAuthor() !== NULL)
            {
                try
                {
                    $this->setVariable("authorName", UserDatabaseHandler::selectById($page->getAuthor())->getName());
                }
                catch(\Exception $e){}
}
        }

        // Generate Preview Image List
        $previewImageSelect = "";

        foreach(FileLister::getUploadedFilesByType(FileLister::FILETYPE_IMAGE) as $image)
        {
            if(($page !== NULL AND $page->getPreviewImage() == $image) OR (isset($_POST['previewImage']) AND $_POST['previewImage'] == $image))
                $selected = self::SELECTED;
            else
                $selected = "";

            $previewImageSelect .= "<option value='$image' $selected>$image</option>\n";
        }

        $this->setVariable("previewImageSelect", $previewImageSelect);

        // Generate page select
        $options = "";

        foreach(Page::TYPES as $pageType)
        {
            if(($page !== NULL AND $page->getType() == $pageType) OR (isset($_POST['type']) AND $_POST['type'] == $pageType))
                $selected = self::SELECTED;
            else
                $selected = "";

            $options .= "<option value='$pageType' $selected>$pageType</option>";
        }

        $this->setVariable("typeSelect", $options);
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        if(isset($_POST['isOnNav']) AND $_POST['isOnNav'] == 0)
            $this->setVariable("isOnNavNo", self::SELECTED);

        return parent::getHTML();
    }

    /**
     * Returns any validation errors encountered when the form is submitted
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $fields = array();

        foreach(Page::FIELDS as $field)
        {
            $fields[$field] = NULL;
        }

        foreach(array_keys($_POST) as $formField)
        {
            $fields[$formField] = $_POST[$formField];
        }


        // URI
        if($this->page === NULL OR $this->page->getUri() != $fields['uri'])
        {
            try
            {
                Page::validateURI($fields['uri']);
            }
            catch(ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        // Title
        try
        {
            Page::validateTitle($fields['title']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // ?NavTitle
        try
        {
            Page::validateNavTitle($fields['navTitle']);

            if(!isset($_POST['navTitle']) OR (isset($_POST['navTitle']) AND strlen($_POST['navTitle']) == 0))
                $_POST['navTitle'] = NULL;
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        //? PreviewImage
        if(!isset($_POST['previewImage']) OR (isset($_POST['previewImage']) AND strlen($_POST['previewImage']) == 0))
            $_POST['previewImage'] = NULL;

        // TYPE
        try
        {
            Page::validateType($fields['type']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Is On Nav
        try
        {
            Page::validateIsOnNav((int)$fields['isOnNav']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Weight
        try
        {
            Page::validateWeight((int)$fields['weight']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        // Protected
        try
        {
            Page::validateProtected((int)$fields['protected']);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}