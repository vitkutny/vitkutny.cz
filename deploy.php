<?php declare(strict_types=1);

namespace Deployer;

require 'recipe/common.php';

// Configuration

set('repository', 'git@github.com:vitkutny/vitkutny.cz.git');
set('shared_files', [
	'app/config/config.local.neon',
]);
set('shared_dirs', [
	'log',
]);
set('writable_dirs', [
	'log',
	'temp',
]);

// Hosts

inventory('hosts.yml');

// Tasks

task('php-fpm:restart', function () {
	run('service php7.1-fpm restart');
});

task('build', [
	'deploy:vendors',
]);

task('deploy', [
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:writable',
	'build',
	'deploy:clear_paths',
	'deploy:symlink',
	'php-fpm:restart',
	'deploy:unlock',
	'cleanup',
	'success',
]);

// if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
