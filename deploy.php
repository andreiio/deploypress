<?php

namespace Deployer;

require 'recipe/common.php';

define('BASEPATH', __DIR__);

require BASEPATH . '/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(BASEPATH);
$dotenv->load();

require BASEPATH . '/config/deploy/deploy.php';

foreach (glob(BASEPATH . '/config/deploy/tasks/*.php') as $filename) {
	require $filename;
}

set('allow_anonymous_stats', false);

?>
