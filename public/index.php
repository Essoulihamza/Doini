<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP', ROOT . "app" . DIRECTORY_SEPARATOR);

define('CORE', APP . "core" . DIRECTORY_SEPARATOR);

define('CONTROLLER', APP . "controller" . DIRECTORY_SEPARATOR);

define('MODEL', APP . "model" . DIRECTORY_SEPARATOR);

define('VIEW', APP . "view" . DIRECTORY_SEPARATOR);

define('HELPERS', APP . "helpers" . DIRECTORY_SEPARATOR);

$modules = [APP, CORE, CONTROLLER, MODEL, VIEW, HELPERS];

set_include_path(ROOT . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));

spl_autoload_register('spl_autoload');

new Application();