<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/22/2019
 * Time: 6:06 PM
 */


namespace views;


use exceptions\ViewException;

abstract class View
{
    const TEMPLATE_PAGE = 'pages';
    const TEMPLATE_CONTENT = 'content';
    const TEMPLATE_ELEMENT = 'elements';

    protected $template;

    /**
     * @param string $htmlDocumentName The name of the html source document (without .html)
     * @param string $type The directory the document is stored in (e.g., content, elements, pages)
     * @return string
     * @throws ViewException
     */
    public static function templateFileContents(string $htmlDocumentName, string $type): string
    {
        $file = dirname(__FILE__) . "/../html/$type/$htmlDocumentName.html";
        if (!is_file($file))
        {
            throw new ViewException(ViewException::MESSAGES[ViewException::TEMPLATE_NOT_FOUND] . ": $htmlDocumentName", ViewException::TEMPLATE_NOT_FOUND);
        }
        return file_get_contents($file);
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        $this->setVariable("baseURI", \CMSConfiguration::CMS_CONFIG['baseURI']);
        $this->setVariable("enabledTheme", \CMSConfiguration::CMS_CONFIG['theme']);
        return preg_replace("/\{\{@(.*)\}\}/", null, $this->template);
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $variableName
     * @param $value
     */
    public function setVariable(string $variableName, $value)
    {
        $this->template = str_replace("{{@$variableName}}", $value, $this->template);
    }

    /**
     * @param string $template
     */
    protected function setTemplate(string $template)
    {
        $this->template = $template;
    }

    /**
     * @param string $htmlDocumentName
     * @param $type
     * @throws ViewException
     */
    protected function setTemplateFromHTML(string $htmlDocumentName, $type)
    {
        $this->template = self::templateFileContents($htmlDocumentName, $type);
    }
}