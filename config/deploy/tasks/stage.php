<?php

namespace Deployer;

desc('Checks for explicit stage name');
task('stage:check', function() {
	if (!input()->hasArgument('stage')) {
		writeln("<error>No stage provided. Quitting...</error>");
		exit;
	}
})->local();

?>
