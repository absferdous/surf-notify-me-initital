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
require_once SSN_PATH . 'admin/class-admin-ui.php';

// Conditionally load popup classes
$options = get_option('ssn_options', []);

if (!empty($options['enable_sales_popup'])) {
    require_once SSN_PATH . 'core/class-sales-popup.php';
}
if (!empty($options['enable_comments_popup'])) {
    require_once SSN_PATH . 'core/class-comments-popup.php';
}
if (!empty($options['enable_social_proof_popup'])) {
    require_once SSN_PATH . 'core/class-social-proof-popup.php';
}
if (!empty($options['enable_memory_bank_popup'])) {
    require_once SSN_PATH . 'core/class-memory-bank-popup.php';
}

function ssn_boot_plugin() {
    $debugger = new SSN_Debugger();
    $loader = new SSN_Loader();
    $options = get_option('ssn_options', []);

    if (!empty($options['enable_sales_popup']) && class_exists('SSN_Sales_Popup')) {
        $loader->add_service(new SSN_Sales_Popup($debugger));
    }
    if (!empty($options['enable_comments_popup']) && class_exists('SSN_Comments_Popup')) {
        $loader->add_service(new SSN_Comments_Popup($debugger));
    }
    if (!empty($options['enable_social_proof_popup']) && class_exists('SSN_Social_Proof_Popup')) {
        $loader->add_service(new SSN_Social_Proof_Popup($debugger));
    }
    if (!empty($options['enable_memory_bank_popup']) && class_exists('SSN_Memory_Bank_Popup')) {
        $loader->add_service(new SSN_Memory_Bank_Popup($debugger));
    }

    $loader->add_service(new SSN_Admin_UI($debugger));
    $loader->run();
}
add_action('plugins_loaded', 'ssn_boot_plugin');
