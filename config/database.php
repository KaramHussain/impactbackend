<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'carepays'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'carepays_testing' => [
            'driver' => 'mysql',
            'host' => env('TEST_DB_HOST', 'localhost'),
            'database' => env('TEST_DB_DATABASE', 'carepays_testing'),
            'username' => env('TEST_DB_USERNAME', 'root'),
            'password' => env('TEST_DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'master_database' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MASTER_DATABASE', '127.0.0.1'),
            'port' => env('DB_PORT_MASTER_DATABASE', '3306'),
            'database' => env('DB_DATABASE_MASTER_DATABASE', 'master_database'),
            'username' => env('DB_USERNAME_MASTER_DATABASE', 'root'),
            'password' => env('DB_PASSWORD_MASTER_DATABASE', ''),
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'preventive_care' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PREVENTIVE_CARE', '127.0.0.1'),
            'port' => env('DB_PORT_PREVENTIVE_CARE', '3306'),
            'database' => env('DB_DATABASE_PREVENTIVE_CARE', 'forge'),
            'username' => env('DB_USERNAME_PREVENTIVE_CARE', 'forge'),
            'password' => env('DB_PASSWORD_PREVENTIVE_CARE', ''),
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'mur' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MUR', '127.0.0.1'),
            'port' => env('DB_PORT_MUR', '3306'),
            'database' => env('DB_DATABASE_MUR', 'mur'),
            'username' => env('DB_USERNAME_MUR', 'root'),
            'password' => env('DB_PASSWORD_MUR', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'icd10cm_cpts_layterms_crosswalk' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_icd10cm_cpts_layterms_crosswalk', '127.0.0.1'),
            'port' => env('DB_PORT_icd10cm_cpts_layterms_crosswalk', '3306'),
            'database' => env('DB_DATABASE_icd10cm_cpts_layterms_crosswalk', 'mur'),
            'username' => env('DB_USERNAME_icd10cm_cpts_layterms_crosswalk', 'root'),
            'password' => env('DB_PASSWORD_icd10cm_cpts_layterms_crosswalk', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'all_cpts_and_icds' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_ALL_CPTS_AND_ICDS', '127.0.0.1'),
            'port' => env('DB_PORT_ALL_CPTS_AND_ICDS', '3306'),
            'database' => env('DB_DATABASE_ALL_CPTS_AND_ICDS', 'mur'),
            'username' => env('DB_USERNAME_ALL_CPTS_AND_ICDS', 'root'),
            'password' => env('DB_PASSWORD_ALL_CPTS_AND_ICDS', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'rules' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_RULES', '127.0.0.1'),
            'port' => env('DB_PORT_RULES', '3306'),
            'database' => env('DB_DATABASE_RULES', 'mur'),
            'username' => env('DB_USERNAME_RULES', 'root'),
            'password' => env('DB_PASSWORD_RULES', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'search_engine' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SEARCH', '127.0.0.1'),
            'port' => env('DB_PORT_SEARCH', '3306'),
            'database' => env('DB_DATABASE_SEARCH', 'search_engine'),
            'username' => env('DB_USERNAME_SEARCH', ''),
            'password' => env('DB_PASSWORD_SEARCH', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'anatomy_testing' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_ANATOMY', '127.0.0.1'),
            'port' => env('DB_PORT_ANATOMY', '3306'),
            'database' => env('DB_DATABASE_ANATOMY', 'anatomy'),
            'username' => env('DB_USERNAME_ANATOMY', 'root'),
            'password' => env('DB_PASSWORD_ANATOMY', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [PDO::ATTR_EMULATE_PREPARES => true]
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
?>