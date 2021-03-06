<?php
/**
 * Zettacast test bootstrap file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2018 Rodrigo Siqueira
 */

/*
 * Ensure the current directory is pointing to the framework's front
 * controller's directory. That MUST BE your public directory.
 */
chdir(dirname(__DIR__));

/*
 * Sets error reporting level and display errors settings. It is recommended to
 * change these values when in production use.
 */
error_reporting(-1);
ini_set('display_errors', 1);

/**#@+
 * Let us define some constant values. Firstly, we have to make it clear that
 * Zettacast is booted and when it happened. These constants actually do not
 * mean much, but may be useful when using Zettacast along with other
 * frameworks. Although we cannot imagine why you would do such a thing, haha.
 * @var mixed Zettacast initialization constants.
 */
define('ZETTACAST', 'Zettacast');
define('ZETTATIME', microtime(true));
/**#@-*/

/**
 * This constant hold the path of the document root, where all framework and
 * applications files can be found from.
 * @var string Document root.
 */
define('ROOTPATH', realpath(dirname(__DIR__)));

/**#@+
 * These constants hold the path of the framework's directories. You should
 * modify these constants every time you change the location or name of the
 * framework's folders.
 * @var string Framework's directories constants.
 */
define('APPPATH', ROOTPATH.'/app');
define('SRCPATH', ROOTPATH.'/src');
define('TMPPATH', ROOTPATH.'/tmp');
define('CFGPATH', APPPATH.'/config');
define('WWWPATH', ROOTPATH.'/public');
/**#@-*/

/*
 * Bootstraping framework. Initializing all functions, objects and handlers
 * needed for a correct Zettacast execution. Besides that, an autoload function
 * is specified so one no longer needs explicitly include class files.
 */
require SRCPATH.'/bootstrap.php';
