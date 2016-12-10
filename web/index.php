<?php
require_once __DIR__.'/../vendor/autoload.php';
$config_path = __DIR__.'/../core/config/config.php';

use WebLab\Core as Core;

$app = Core::getInstance();
$app->run($config_path);
