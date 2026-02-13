<?php
/**
 * Plugin Name: WPPRO ADA
 * Plugin URI: https://example.com
 * Description: ADA Compliance Plugin with custom CSS and JavaScript settings
 * Version: 1.0.0
 * Author: Rafik Boghouzian
 * Author URI: https://example.com
 * License: GPL2
 * Text Domain: wppro-ada
 * Domain Path: /languages
 */

// Prevent direct access to the plugin file
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WPPRO_ADA_VERSION', '1.0.0');
define('WPPRO_ADA_PATH', plugin_dir_path(__FILE__));
define('WPPRO_ADA_URL', plugin_dir_url(__FILE__));

// Include the main plugin class
require_once WPPRO_ADA_PATH . 'includes/class-wppro-ada.php';

// Register activation hook
register_activation_hook(__FILE__, ['WPPRO_ADA', 'activate']);

// Register deactivation hook
register_deactivation_hook(__FILE__, ['WPPRO_ADA', 'deactivate']);

// Initialize plugin
add_action('plugins_loaded', ['WPPRO_ADA', 'instance']);
