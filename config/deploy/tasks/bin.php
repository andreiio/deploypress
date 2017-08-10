<?php

namespace Deployer;

set('bin/composer', function() {
	if (commandExist('composer')) {
		$cmd = locateBinaryPath('composer');
	}

	if (empty($cmd)) {
		$cmd = '{{deploy_path}}/shared/composer.phar';

		if (!test("[ -f $cmd ]")) {
			run('cd {{deploy_path}}/shared && curl -sS https://getcomposer.org/installer | {{bin/php}}');
		}
	}

	return "{{bin/php}} $cmd";
});

set('bin/wp', function() {
	if (commandExist('wp')) {
		$cmd = locateBinaryPath('wp');
	}

	if (empty($cmd)) {
		$cmd = '{{deploy_path}}/shared/wp-cli.phar';

		if (!test("[ -f $cmd ]")) {
			run('wget -nc -P {{deploy_path}}/shared https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar');
		}
	}

	return "{{bin/php}} $cmd --path={{current_path}}";
});

?>
