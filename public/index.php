<?php

use Zend\Mvc\Application;
use Zend\Log\Logger;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

/** I really don't like something like this: __DIR__ . '../../../../../../../' */
define('ROOT_PATH', dirname(__DIR__));
/** Is development environment or not */
define('DEVELOPMENT_ENV', (getenv('APPLICATION_ENV') === 'development') ? true : false);
/** The locale in which the whole application is written */
define('APPLICATION_LOCALE', 'en_GB');
/** The language in which the whole application is written ie. en, en-us, pt-br */
define('APPLICATION_LANGUAGE', 'en');

if (DEVELOPMENT_ENV) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup auto-loading
require ROOT_PATH . '/init_autoloader.php';

$config = require ROOT_PATH . '/config/application.config.php';

/** @var Application $app */
$app = Application::init($config);

try {
    $app->run();
} catch (\Exception $e) {
    /** @var Logger $logger */
    $logger = $app->getServiceManager()->get('Logger');
    $logger->crit($e);

    echo 'There was an error, please contact with the administrator.';

    if (DEVELOPMENT_ENV) {
        echo PHP_EOL . PHP_EOL;
        echo $e;
    }
}
