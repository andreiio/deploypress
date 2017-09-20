<?php

namespace Deployer;

desc('Pulls the database from production');
task('db:pull', function() {
	$stage = get('stage');
	$shared = '{{deploy_path}}/shared';

	if ($stage != 'production') {
		writeln("<error>For your own safety, db:pull only runs on production.</error>");
	} else {
		$random = str_pad(rand(0, pow(10, 5)), 5, '0', STR_PAD_LEFT);

		$remote = "db-{$random}.sql.gz";
		$local = BASEPATH . "/shared/db-{$stage}.sql.gz";

		run("{{bin/wp}} db export --add-drop-table - | gzip > $shared/$remote");
		runLocally("scp {{hostname}}:$shared/$remote $local");
		run("rm $shared/$remote");
	}
});

desc('Pushes the production database to any non-production stage');
task('db:push', function() {
	$stage = get('stage');
	$shared = '{{deploy_path}}/shared';

	if ($stage == 'production') {
		writeln("<error>For your own safety, db:push does not run on production.</error>");
	} else {
		$local = BASEPATH . "/shared/db-production.sql.gz";
		$remote = 'db-production.sql.gz';

		if (!testLocally("[ -f $local ]")) {
			writeln("<error>No database dump found. You should first run db:pull from production.</error>");
		} else {
			runLocally("scp $local {{hostname}}:$shared/$remote");
			runLocally("rm $local");

			run("gunzip -c $shared/$remote | {{bin/wp}} db import -");
			run("rm $shared/$remote");
		}
	}
});

?>
