<?php
/*
Plugin Name: Sleekode Performance Core
Description: A lightweight performance and maintenance toolkit for WordPress.
Version: 1.0.0
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.1
Author: Sleekode
Author URI: https://github.com/Sleekode
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: sleekode-performance-core
Domain Path: /languages

@package SleekodePerformanceCore
*/

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define(
	'SLEEKODE_PERFORMANCE_CORE_VERSION',
	'1.0.0'
);

define(
	'SLEEKODE_PERFORMANCE_CORE_PATH',
	plugin_dir_path( __FILE__ )
);

define(
	'SLEEKODE_PERFORMANCE_CORE_URL',
	plugin_dir_url( __FILE__ )
);

require_once SLEEKODE_PERFORMANCE_CORE_PATH . 'includes/class-loader.php';

Sleekode\PerformanceCore\Loader::register();

require_once SLEEKODE_PERFORMANCE_CORE_PATH . 'includes/class-plugin.php';

Sleekode\PerformanceCore\Plugin::instance()->boot();