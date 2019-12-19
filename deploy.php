<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@github.com:xup6m6fu04/profile.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('inredis.com')
    ->set('deploy_path', '/home/ubuntu/web/profile');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

task('init', function() {
   run('cp /home/ubuntu/web/profile/current/.env.example /home/ubuntu/web/profile/shared/.env');
   run('cd /home/ubuntu/web/profile/current && /usr/bin/php artisan key:generate');
   run('cd /home/ubuntu/web/profile/current && /usr/bin/php artisan config:cache');
});

after('cleanup', 'init');

