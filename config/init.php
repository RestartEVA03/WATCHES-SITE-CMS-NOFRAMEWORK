<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . "/web");
define("APP", ROOT . "/app");
define("CORE", ROOT . "/vendor/watchesshop/core");
define("LIBS", ROOT . "/vendor/watchesshop/core/libs");
define("CACHE", ROOT . "/tmp/cache");
define("CONF", ROOT . "/config");
define("LAYOUT", "watches");

//http://watchesshop/web/index.php
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

//http://watchesshop/web/
$app_path = preg_replace("#[^/]+$#", '', $app_path);

//http://watchesshop
$app_path = str_replace('/web/', '', $app_path);

define("PATH", $app_path);
define("ADMIN", PATH . '/admin');

require_once ROOT . '/vendor/autoload.php';