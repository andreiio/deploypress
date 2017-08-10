<?php

namespace Deployer;

require 'recipe/common.php';

set('allow_anonymous_stats', false);

define('BASEPATH', __DIR__);

require BASEPATH . '/config/deploy/deploy.php';

foreach (glob(BASEPATH . '/config/deploy/tasks/*.php') as $filename) {
	require $filename;
}

?>
