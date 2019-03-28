<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/27/2019
 * Time: 7:30 PM
 */


namespace admin\views\forms;


use models\Doorway;

class DoorwayForm extends Form
{
    /**
     * DoorwayForm constructor.
     * @param Doorway|null $doorway
     * @throws \exceptions\ViewException
     */
    public function __construct(?Doorway $doorway = NULL)
    {
        $this->setTemplateFromHTML("DoorwayForm", self::ADMIN_TEMPLATE_FORM);

        if($doorway !== NULL)
        {
            $this->setVariable("uri", $doorway->getUri());
            $this->setVariable("destination", $doorway->getDestination());

            if($doorway->getEnabled() == 0)
                $this->setVariable("enabledNo", self::SELECTED);
        }
    }

    /**
     * Selected correct ENABLED value
     * @return string
     */
    public function getHTML(): string
    {
        if(isset($_POST['enabled']) AND $_POST['enabled'] == 0)
            $this->setVariable("enabledNo", self::SELECTED);

        return parent::getHTML();
    }
}