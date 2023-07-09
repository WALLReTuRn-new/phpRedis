<?php

$autoloader = new \WebSiteToYou\System\Library\Autoloader();
$autoloader->register('WebSiteToYou\\' . APPLICATION, DIR_APPLICATION);
$autoloader->register('WebSiteToYou\System', DIR_SYSTEM);

require_once(DIR_SYSTEM . 'vendor.php');

// Registry
$registry = new \WebSiteToYou\System\Library\Registry();
$registry->set('autoloader', $autoloader);

// Config
$config = new \WebSiteToYou\System\Library\Config();
$config->addPath(DIR_CONFIG);

// Load the default config
$config->load('App');
$config->load(strtolower(APPLICATION));

// Set the default application
$config->set('application', APPLICATION);
$registry->set('config', $config);

// Set the default time zone
date_default_timezone_set($config->get('date_timezone'));

// Event
$event = new \WebSiteToYou\System\Library\Event($registry);
$registry->set('event', $event);

// Event Register
if ($config->has('action_event')) {
    foreach ($config->get('action_event') as $key => $value) {
        foreach ($value as $priority => $action) {
            $event->register($key, new \WebSiteToYou\System\Library\Action($action), $priority);
        }
    }
}

// Loader

$loader = new \WebSiteToYou\System\Library\Loader($registry);
$registry->set('loading', $loader, $datainfo = array());

// Request
$request = new \WebSiteToYou\System\Library\Request();
$registry->set('request', $request);

// Response
$response = new \WebSiteToYou\System\Library\Response();

foreach ($config->get('response_header') as $header) {
    $response->addHeader($header);
}

$response->addHeader('Access-Control-Allow-Origin: *');
$response->addHeader('Access-Control-Allow-Credentials: true');
$response->addHeader('Access-Control-Max-Age: 1000');
$response->addHeader('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding');
$response->addHeader('Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE');
$response->addHeader('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$response->addHeader('Pragma: no-cache');
//If no have all setting when active Expires ERROR 500
//$response->addHeader('Expires', '0');
$response->setCompression($config->get('response_compression'));
$registry->set('response', $response);
// Database
if ($config->get('db_autostart')) {
    $db = new \WebSiteToYou\System\Library\DB($config->get('db_engine'), $config->get('db_hostname'), $config->get('db_username'), $config->get('db_password'), $config->get('db_database'), $config->get('db_port'));
    $registry->set('db', $db);

    // Sync PHP and DB time zones
    // $db->query("SET time_zone = '" . $db->escape(date('P')) . "'");

    $dbRedis = new \WebSiteToYou\System\Library\DB(DBRedis_DRIVER, DBRedis_HOSTNAME, DBRedis_USERNAME, DBRedis_PASSWORD, DBRedis_DATABASE, DBRedis_PORT);
    $registry->set('dbRedis', $dbRedis);
}
// Template
$template = new \WebSiteToYou\System\Library\Template($config->get('template_engine'));
$template->addPath(DIR_TEMPLATE);
$registry->set('template', $template);

// Language
$language = new \WebSiteToYou\System\Library\Language($config->get('language_code'));
$language->addPath(DIR_LANGUAGE);
$language->load($config->get('language_code'));
$registry->set('language', $language);

// Document
$registry->set('document', new \WebSiteToYou\System\Library\Document());

$action = '';

// Pre Actions
foreach ($config->get('action_pre_action') as $pre_action) {
    $pre_action = new \WebSiteToYou\System\Library\Action($pre_action);

    $result = $pre_action->execute($registry);

    if ($result instanceof \WebSiteToYou\System\Library\Action) {
        $action = $result;

        break;
    }

    // If action can not be executed then we return an action error object.
    if ($result instanceof \Exception) {
        $action = 'have error with loading';

        $error = '';

        break;
    }
}

// Route
if (isset($request->get['route'])) {
    $request->get['route'] = str_replace('%7C', '|', (string) $request->get['route']);
}



if (!$action) {
    if (!empty($request->get['route'])) {
        $action = new \WebSiteToYou\System\Library\Action((string) $request->get['route']);
    } else {
        $action = new \WebSiteToYou\System\Library\Action($config->get('action_default'));
    }
}

// Dispatch
while ($action) {
    // Get the route path of the object to be executed.
    $route = $action->getId();
    $args = [];
    $output = '';

    // Keep the original trigger.
    $trigger = $action->getId();

    $event->trigger('controller/' . $trigger . '/before', [&$route, &$args]);

    // Execute the action.
    $result = $action->execute($registry, $args);

    $action = '';

    if ($result instanceof \WebSiteToYou\System\Library\Action) {
        $action = $result;
    }

    // If action can not be executed then we return the action error object.
    if ($result instanceof \Exception) {
        $action = $error;

        // In case there is an error we don't want to infinitely keep calling the action error object.
        $error = '';
    }

    $event->trigger('controller/' . $trigger . '/after', [&$route, &$args, &$output]);
}


// Output
$response->output();
