<?php

define('APPLICATION', 'App');


// HTTP
define('HTTP_SERVER', 'http://localhost/');

define('DIR_APP', 'C:/xampp/htdocs/phpredis/');
define('DIR_APPLICATION', DIR_APP . 'app/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'views/');
define('DIR_SYSTEM', DIR_APP . 'system/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_STORAGE', DIR_SYSTEM . '');
define('DIR_CACHE', DIR_STORAGE . 'cache/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'redistest');
define('DB_PORT', '3306');
define('DB_PREFIX', '');

define('DBRedis_DRIVER', 'redis');
define('DBRedis_HOSTNAME', '127.0.0.1');
define('DBRedis_USERNAME', 'default');
define('DBRedis_PASSWORD', 'foobared');
define('DBRedis_DATABASE', '1');
define('DBRedis_PORT', '6379');
define('DBRedis_PREFIX', '');
