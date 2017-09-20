<?php

namespace Deployer;

desc('Pulls files from production');
task('files:pull', function() {
	$stage = get('stage');
	$shared = '{{deploy_path}}/shared';

	if ($stage != 'production') {
		writeln("<error>For your own safety, files:pull only runs on production.</error>");
	} else {
		$random = str_pad(rand(0, pow(10, 5)), 5, '0', STR_PAD_LEFT);

		$remote = "files-{$random}.tar.gz";
		$local = BASEPATH . "/shared/files-{$stage}.tar.gz";

		run("tar -czf $shared/$remote -C $shared {{uploads_dir}}");
		runLocally("scp {{hostname}}:$shared/$remote $local");
		run("rm $shared/$remote");
	}
});

desc('Pushes the production files to any non-production stage');
task('files:push', function() {
	$stage = get('stage');
	$shared = '{{deploy_path}}/shared';

	if ($stage == 'production') {
		writeln("<error>For your own safety, files:push does not run on production.</error>");
	} else {
		$local = BASEPATH . "/shared/files-production.tar.gz";
		$remote = 'files-production.tar.gz';

		if (!testLocally("[ -f $local ]")) {
			writeln("<error>No file dump found. You should first run files:pull from production.</error>");
		} else {
			runLocally("scp $local {{hostname}}:$shared/$remote");
			runLocally("rm $local");

			run("tar -xzf $shared/$remote -C $shared");
			run("rm $shared/$remote");
		}
	}
});

?>
