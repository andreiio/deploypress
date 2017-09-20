<?php

namespace Deployer;

// Get repository remote origin url from local git config
set('repository', getenv('APP_REPO'));

// Use date format for release name
set('release_name', function() {
    return date('YmdHis');
});

set('deploy_path', function() {
	return BASEPATH;
});

set('keep_releases', 5);

set('git_tty', false);

set('uploads_dir', 'public/content/uploads');

set('shared_files', [
    '.env',
]);

set('shared_dirs', [
	get('uploads_dir')
]);

set('writable_dirs', [
	get('uploads_dir')
]);

set('writable_mode', 'chmod');

set('clear_paths', [
	'public/wp/wp-content'
]);

// Mock host for local tasks
localhost();

// Load target hosts
inventory(BASEPATH . '/config/deploy/hosts.yml');

desc('Deploy your project');
task('deploy', [
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:writable',
	'deploy:vendors',
	'deploy:clear_paths',
	'deploy:symlink',
	'deploy:unlock',
	'cleanup',
	'success'
]);

// If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

before('deploy', 'stage:check');

?>
