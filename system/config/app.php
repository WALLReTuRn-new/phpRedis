<?php

// Site
$_['site_url'] = HTTP_SERVER;

// Language
$_['language_code'] = 'en-gb';

// Date
$_['date_timezone'] = 'UTC';

//GDPR
$_['config_gdpr_status'] = 0;

// Mail
$_['mail_engine'] = 'mail'; // mail or smtp
$_['mail_from'] = ''; // Your E-Mail
$_['mail_sender'] = ''; // Your name or company name
$_['mail_reply_to'] = ''; // Reply to E-Mail
$_['mail_smtp_hostname'] = '';
$_['mail_smtp_username'] = '';
$_['mail_smtp_password'] = '';
$_['mail_smtp_port'] = 25;
$_['mail_smtp_timeout'] = 5;
$_['mail_verp'] = false;
$_['mail_parameter'] = '';


// Database
$_['db_autostart'] = true;
$_['db_engine'] = DB_DRIVER; // mysqli, pdo or pgsql
$_['db_hostname'] = DB_HOSTNAME;
$_['db_username'] = DB_USERNAME;
$_['db_password'] = DB_PASSWORD;
$_['db_database'] = DB_DATABASE;
$_['db_port'] = DB_PORT;

//NO SQL
// Database
$_['dbRedis_engine'] = DBRedis_DRIVER; // mysqli, pdo or pgsql
$_['dbRedis_hostname'] = DBRedis_HOSTNAME;
$_['dbRedis_username'] = DBRedis_USERNAME;
$_['dbRedis_password'] = DBRedis_PASSWORD;
$_['dbRedis_database'] = DBRedis_DATABASE;
$_['dbRedis_port'] = DBRedis_PORT;


// Template
$_['template_engine']      = 'twig';
$_['template_extension']   = '.twig';

// Response
$_['response_header']      = ['Content-Type: text/html; charset=utf-8'];
$_['response_compression'] = 0;
// Session
$_['session_autostart'] = false;
$_['session_engine'] = 'db'; // db or file

//Add controller where ask loading before base index
$_['action_pre_action'] = [
        //'common/start'
];

// Action Events
$_['action_event'] = [
    'controller/*/before' => [
        0 => 'event/language|before',
    //1 => 'event/debug|before'
    ],
    'controller/*/after' => [
        0 => 'event/language|after',
    //2 => 'event/debug|after'
    ],
    'view/*/before' => [
        500 => 'event/theme',
        998 => 'event/language'
    ],
    'language/*/after' => [
        0 => 'event/translation'
    ]
];
