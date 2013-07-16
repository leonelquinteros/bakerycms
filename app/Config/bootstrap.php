<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 *   Cache::config('default', array(
 *      'engine' => 'File', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 *      'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 *      'lock' => false, //[optional]  use file locking
 *      'serialize' => true, // [optional]
 *      'mask' => 0666, // [optional] permission mask to use when creating cache files
 *  ));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 *   Cache::config('default', array(
 *      'engine' => 'Apc', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *  ));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 *   Cache::config('default', array(
 *      'engine' => 'Xcache', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *      'user' => 'user', //user from xcache.admin.user settings
 *      'password' => 'password', //plaintext password (xcache.admin.pass)
 *  ));
 *
 * Memcache (http://memcached.org/)
 *
 *   Cache::config('default', array(
 *      'engine' => 'Memcache', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *      'servers' => array(
 *          '127.0.0.1:11211' // localhost, default port 11211
 *      ), //[optional]
 *      'persistent' => true, // [optional] set this to false for non-persistent connections
 *      'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *  ));
 *
 *  Wincache (http://php.net/wincache)
 *
 *   Cache::config('default', array(
 *      'engine' => 'Wincache', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *  ));
 *
 * Redis (http://http://redis.io/)
 *
 *   Cache::config('default', array(
 *      'engine' => 'Redis', //[required]
 *      'duration'=> 3600, //[optional]
 *      'probability'=> 100, //[optional]
 *      'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *      'server' => '127.0.0.1' // localhost
 *      'port' => 6379 // default port 6379
 *      'timeout' => 0 // timeout in seconds, 0 = unlimited
 *      'persistent' => true, // [optional] set this to false for non-persistent connections
 *  ));
 */

/**
 * Dev env bootstrap
 */
if(Configure::read('debug') > 0)
{
    App::import('Lib', 'Maintenance');

    Maintenance::checkCacheDirs();
    Maintenance::checkMediaDir();
}

/**
 * Cache configuration
 */
define('CACHE_ENGINE', 'File');

Cache::config('default', array(
                            'engine' => CACHE_ENGINE,
                            'prefix' => 'bakerycms_default_',
                            'duration'=> 3600,
                        )
);

Cache::config('short', array(
                            'engine' => CACHE_ENGINE,
                            'prefix' => 'bakerycms_short_',
                            'duration'=> 60,
                        )
);

Cache::config('ten', array(
                            'engine' => CACHE_ENGINE,
                            'prefix' => 'bakerycms_ten_',
                            'duration'=> 600,
                        )
);

Cache::config('long', array(
                            'engine' => CACHE_ENGINE,
                            'prefix' => 'bakerycms_long_',
                            'duration'=> '+1 day',
                        )
);

Cache::config('permanent', array(
                            'engine' => CACHE_ENGINE,
                            'prefix' => 'bakerycms_permanent_',
                            'duration'=> '+1 year',
                        )
);


/**
 * Try to deal with GPC enabled servers.
 */
if (get_magic_quotes_gpc())
{
    ini_set('magic_quotes_gpc', 0);

    if (get_magic_quotes_gpc()) {
        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)) {
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                } else {
                    $process[$key][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
    }
}

// i18n constants
define('DEFAULT_SUPPORTED_LANGUAGE', 'eng');
define('SUPPORTED_LANGUAGES', 'eng');

// Supported menus
define('SITE_MENUS', 'Main,Bottom');

// Zend Framework autoloader
$ip = ini_get('include_path');
ini_set('include_path', $ip . PATH_SEPARATOR . ROOT);

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

// Load some useful classes
App::import('Utility', 'Sanitize');
App::import('Lib', 'Language');

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models', '/next/path/to/models'),
 *     'Model/Behavior'            => array('/path/to/behaviors', '/next/path/to/behaviors'),
 *     'Model/Datasource'          => array('/path/to/datasources', '/next/path/to/datasources'),
 *     'Model/Datasource/Database' => array('/path/to/databases', '/next/path/to/database'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions', '/next/path/to/sessions'),
 *     'Controller'                => array('/path/to/controllers', '/next/path/to/controllers'),
 *     'Controller/Component'      => array('/path/to/components', '/next/path/to/components'),
 *     'Controller/Component/Auth' => array('/path/to/auths', '/next/path/to/auths'),
 *     'Controller/Component/Acl'  => array('/path/to/acls', '/next/path/to/acls'),
 *     'View'                      => array('/path/to/views', '/next/path/to/views'),
 *     'View/Helper'               => array('/path/to/helpers', '/next/path/to/helpers'),
 *     'Console'                   => array('/path/to/consoles', '/next/path/to/consoles'),
 *     'Console/Command'           => array('/path/to/commands', '/next/path/to/commands'),
 *     'Console/Command/Task'      => array('/path/to/tasks', '/next/path/to/tasks'),
 *     'Lib'                       => array('/path/to/libs', '/next/path/to/libs'),
 *     'Locale'                    => array('/path/to/locales', '/next/path/to/locales'),
 *     'Vendor'                    => array('/path/to/vendors', '/next/path/to/vendors'),
 *     'Plugin'                    => array('/path/to/plugins', '/next/path/to/plugins'),
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */


/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 */
CakePlugin::loadAll(array(
                        array(
                            'bootstrap' => true,
                            'routes'    => true,
                        ),
                    )
);


/**
 * You can attach event listeners to the request lifecyle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *      'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *      'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *      array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *      array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));
