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


use exceptions\ValidationException;
use models\Doorway;

class DoorwayForm extends Form
{
    private $doorway;
    /**
     * DoorwayForm constructor.
     * @param Doorway|null $doorway
     * @throws \exceptions\ViewException
     */
    public function __construct(?Doorway $doorway = NULL)
    {
        $this->doorway = $doorway;

        $this->setTemplateFromHTML("DoorwayForm", self::ADMIN_TEMPLATE_FORM);

        if($doorway !== NULL)
        {
            $this->setVariable("uri", htmlentities($doorway->getUri()));
            $this->setVariable("destination", htmlentities($doorway->getDestination()));

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

    /**
     * @return array
     */
    public function validate(): array
    {
        $errors = array();

        $uri = NULL;
        $destination = NULL;
        $enabled = NULL;

        if(isset($_POST['uri']))
            $uri = $_POST['uri'];

        if(isset($_POST['destination']))
            $destination = $_POST['destination'];

        if(isset($_POST['enabled']))
            $enabled = (int)$_POST['enabled'];

        // If we are editing a doorway and the URI has not changed do not validate it
        if($this->doorway === NULL OR $this->doorway->getUri() != $uri)
        {
            try
            {
                Doorway::validateURI($uri);
            }
            catch (ValidationException $e)
            {
                $errors[] = $e->getMessage();
            }
        }

        try
        {
            Doorway::validateDestination($destination);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        try
        {
            Doorway::validateEnabled($enabled);
        }
        catch(ValidationException $e)
        {
            $errors[] = $e->getMessage();
        }

        return $errors;
    }
}