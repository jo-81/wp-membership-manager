<?php

/*
 * Plugin Name:       WP Membership Manager
 * Description:       This WordPress plugin will allow you to create a customizable member area for your registered users.
 * Version:           0.0.1
 * Requires at least: 6.4
 * Requires PHP:      8.2
 * Author:            Geoffroy Colpart
 * Text Domain:       wp-membership-manager
 * Domain Path:       /languages
 */

use Wp_Membership_Manager\Exception\Not_Found_Exception;
use Wp_Membership_Manager\WP_Membership_Manager;

define("WP_MM_TEMPLATES", plugin_dir_path(__FILE__). "templates");

$autoload_file = plugin_dir_path( __FILE__ ) . "vendor/autoload.php";
if (! file_exists($autoload_file)) {
    throw new Not_Found_Exception(__("autolaod not found", "wp-membership-manager"));
}

require $autoload_file;

$app = new WP_Membership_Manager;
$app->init();
$app->run();
