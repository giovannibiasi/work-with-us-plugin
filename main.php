<?php
/**
 * @package Work With Us Plugin
 * @version 1.0
 */
/*
Plugin Name: Work With Us
Description: A plugin, made for a job application to Il Post, that allows administrators to edit and insert a custom call to action inside posts with a specific tag.
Author: Giovanni Biasi
Version: 1.0
Author URI: https://www.giovannibiasi.com
Text Domain: work-with-us-plugin
*/

/* Define constants */
define( 'WORK_WITH_US_DIR', substr( plugin_dir_path( __FILE__ ), 0, -1 ) );
define( 'WORK_WITH_US_URL', substr( plugin_dir_url( __FILE__ ), 0, -1 ) );

/* Require */
require_once( 'inc/functions.php' );?>