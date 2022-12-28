<?php

$base_url = 'https://' . $_SERVER['HTTP_X_FORWARDED_HOST'];

$databases['default']['default'] = array (
    'database' => getenv('POSTGRES_DB'),
    'username' => getenv('POSTGRES_USER'),
    'password' => getenv('POSTGRES_PASSWORD'),
    'prefix' => '',
    'host' => getenv('POSTGRES_HOST'),
    'port' => getenv('POSTGRES_PORT'),
    'namespace' => 'Drupal\\Core\\Database\\Driver\\pgsql',
    'driver' => 'pgsql',
);

$settings['hash_salt'] = json_encode($databases);

$settings['file_private_path'] = '/app/private';

// Email sending via AWS SES.
$config['system.mail']['interface']['default'] = 'ses_mail';
$config['system.mail']['interface']['webform'] = 'ses_mail';

// Single Source of Truth (SSoT) configuration.
$config['workbc']['ssot_url'] = getenv('SSOT_URL');

$config['jobboard']['jobboard_api_url_frontend'] = getenv('JOBBOARD_API_URL');
$config['jobboard']['jobboard_api_url_backend'] = getenv('JOBBOARD_API_INTERNAL_URL');
$config['jobboard']['find_job_url'] = '/search-and-prepare-job/find-jobs';
$config['jobboard']['find_job_account_url'] = '/account';
