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
use models\Page;

class PageForm extends Form
{
    /**
     * PageForm constructor.
     * @param Page|null $page
     * @throws \exceptions\ViewException
     */
    public function __construct(?Page $page = NULL)
    {
        $this->setTemplateFromHTML("PageForm", self::ADMIN_TEMPLATE_FORM);

        if($page !== NULL)
        {
            $this->setVariable("uri", htmlentities($page->getUri()));
            $this->setVariable("title", htmlentities($page->getTitle()));
            $this->setVariable("navTitle", htmlentities($page->getNavTitle()));
            $this->setVariable("weight", $page->getWeight());

            if($page->getIsOnNav() == 0)
                $this->setVariable("isOnNavNo", self::SELECTED);

            if($page->getAuthor() !== NULL)
            {
                try
                {
                    $this->setVariable("authorName", UserDatabaseHandler::selectById($page->getAuthor())->getName());
                }
                catch(\Exception $e){}
}
        }

        // Generate page select
        $options = "";

        foreach(Page::TYPES as $pageType)
        {
            if($page !== NULL AND $page->getType() == $pageType)
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
}