<?php
/**
 * Plugin Name: Poll System
 * Plugin URI: https://curlware.com
 * Description: Poll generate plugin.
 * Version: 1.0
 * Author: Curlware
 * Author URI: https://curlware.com/
 * Text Domain: poll-system
 * Domain Path: /languages
 * License: GPL2
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path
define('POLL_SYS_PATH', plugin_dir_path(__FILE__));

// Include necessary files
require_once POLL_SYS_PATH . 'admin/poll-sys-admin-interface.php';
require_once POLL_SYS_PATH . 'admin/poll-sys-add-new-interface.php';
require_once POLL_SYS_PATH . 'admin/poll-sys-edit-interface.php'; // Include the new edit interface file
require_once POLL_SYS_PATH . 'includes/poll-sys-functions.php';

// Enqueue admin scripts and styles
function poll_sys_enqueue_admin_assets() {
    wp_enqueue_style('poll-sys-admin-style', plugins_url('assets/css/admin-style.css', __FILE__) ,array(), time());
    wp_enqueue_script('poll-sys-admin-script', plugins_url('assets/js/admin-script.js', __FILE__), array('jquery'), time(), true);
    wp_localize_script('poll-sys-admin-script', 'pollSysAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('poll_sys_nonce'),
        'edit_poll_id' => isset($_GET['poll_id']) ? absint($_GET['poll_id']) : 0,
        'polls' => get_option('poll_sys_polls', array())
    ));
}
add_action('admin_enqueue_scripts', 'poll_sys_enqueue_admin_assets');

// Add admin menu
function poll_sys_add_admin_menu() {
    add_menu_page(
        'Poll System', 
        'Poll Question List', 
        'manage_options', 
        'poll-system', 
        'poll_sys_admin_page', 
        'dashicons-chart-bar'
    );
    add_submenu_page(
        'poll-system',          
        'Add New Poll',         
        'Add New',              
        'manage_options',       
        'poll-system-add-new',  
        'poll_sys_add_new_page' 
    );
    add_submenu_page(
        null,                   
        'Edit Poll',            
        'Edit Poll',            
        'manage_options',       
        'poll-system-edit',     
        'poll_sys_edit_page' 
    );
}
add_action('admin_menu', 'poll_sys_add_admin_menu');
