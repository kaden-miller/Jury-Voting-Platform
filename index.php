<?php

/**
 * Plugin Name:       Jury Voting Platform
 * Description:       Voting platform for the jury of the Eurovision Song Contest
 * Version:           1.0.0
 * Author:            coding.pizza
 * Author URI:        https://www.coding.pizza/
 * License:           GPL License
 * License URI:       https://spdx.org/licenses/GPL-3.0-or-later.html
 */



 // Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );


// Plugin Defines
define( "WPS_FILE", __FILE__ );
define( "WPS_DIRECTORY", dirname(__FILE__) );
define( "WPS_TEXT_DOMAIN", dirname(__FILE__) );
define( "WPS_DIRECTORY_BASENAME", plugin_basename( WPS_FILE ) );
define( "WPS_DIRECTORY_PATH", plugin_dir_path( WPS_FILE ) );
define( "WPS_DIRECTORY_URL", plugins_url( null, WPS_FILE ) );

// Require the main class file
require_once( WPS_DIRECTORY_PATH . '/includes/main-class.php' );
