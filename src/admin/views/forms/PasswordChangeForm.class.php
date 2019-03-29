<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/29/2019
 * Time: 1:34 PM
 */


namespace admin\views\forms;


class PasswordChangeForm extends Form
{
    /**
     * PasswordChangeForm constructor.
     * @throws \exceptions\ViewException
     */
    public function __construct()
    {
        $this->setTemplateFromHTML("PasswordChangeForm", self::ADMIN_TEMPLATE_FORM);
    }
}