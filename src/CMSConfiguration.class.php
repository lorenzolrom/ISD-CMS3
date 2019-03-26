<?php
/**
 * LLR Technologies & Associated Services
 * Information Systems Development
 *
 * Content Management System 3
 *
 * User: lromero
 * Date: 3/9/2019
 * Time: 2:42 PM
 */


abstract class CMSConfiguration
{
    const CMS_CONFIG = [
        'siteTitle' => 'My Website',
        'siteDescription' => 'Welcome to my website!',
        'theme' => 'default',

        'baseURL' => 'http://www.my.domain',
        'baseURI' => '/',

        'cookieName' => 'CMS3_COOKIE',

        'adminURI' => 'user/',

        'databaseHost' => 'my.database.server',
        'databaseName' => 'my.database',
        'databaseUser' => 'my.username',
        'databasePassword' => 'my.password'
    ];
}