<?php

namespace Deployer;

desc('Create local shared directory structure');
task('local:init', function() {
	$shared = BASEPATH . '/shared';

	foreach (get('shared_dirs') as $dir) {
		if (!test("[ -d $shared/$dir ]"))
			run("mkdir -p $shared/$dir");

		run("{{bin/symlink}} $shared/$dir {{deploy_path}}/$dir");
	}
})->local();

?>
