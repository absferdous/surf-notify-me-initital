<?php
/*
Plugin Name: Surf Smart Notify CPT
Description: All-in-one smart notification plugin (Recent Sales, Comments, Subscriptions, Social Proof)
Version: 1.0
Author: Surf Lab
*/

if (!defined('ABSPATH')) exit;

define('SSN_VERSION', '1.0');
define('SSN_PATH', plugin_dir_path(__FILE__));
define('SSN_URL', plugin_dir_url(__FILE__));

require_once SSN_PATH . 'core/class-loader.php';
require_once SSN_PATH . 'core/class-debugger.php';
require_once SSN_PATH . 'core/class-sales-popup.php';
require_once SSN_PATH . 'admin/class-admin-ui.php';

function ssn_boot_plugin() {
    $debugger = new SSN_Debugger();

    $loader = new SSN_Loader();
    $loader->add_service(new SSN_Sales_Popup($debugger));
    $loader->add_service(new SSN_Admin_UI($debugger));
    $loader->run();
}
add_action('plugins_loaded', 'ssn_boot_plugin');