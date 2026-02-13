<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class WPPRO_ADA {

    private static $instance = null;
    private $db_version = '1.0.0';
    private $table_name = '';

    /**
     * Singleton pattern
     */
    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'wppro_ada_settings';

        // Admin menu and settings page
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);

        // Load frontend styles and scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);

        // Handle save request
        add_action('admin_init', [$this, 'handle_settings_save']);
    }

    /**
     * Plugin activation hook
     */
    public static function activate() {
        self::instance()->create_database_tables();
    }

    /**
     * Plugin deactivation hook
     */
    public static function deactivate() {
        // Cleanup if needed
    }

    /**
     * Create database tables on activation
     */
    private function create_database_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            setting_name varchar(100) NOT NULL,
            setting_value longtext NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY setting_name (setting_name)
        ) {$charset_collate};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        // Initialize default settings
        $this->initialize_default_settings();
    }

    /**
     * Initialize default settings
     */
    private function initialize_default_settings() {
        global $wpdb;

        $existing = $wpdb->get_row(
            "SELECT * FROM {$this->table_name} WHERE setting_name = 'custom_js'"
        );

        if (!$existing) {
            $wpdb->insert(
                $this->table_name,
                ['setting_name' => 'custom_js', 'setting_value' => ''],
                ['%s', '%s']
            );
            $wpdb->insert(
                $this->table_name,
                ['setting_name' => 'custom_css', 'setting_value' => ''],
                ['%s', '%s']
            );
            $wpdb->insert(
                $this->table_name,
                ['setting_name' => 'js_location', 'setting_value' => 'head'],
                ['%s', '%s']
            );
        }
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'WPPRO ADA', // Page title
            'WPPRO ADA', // Menu title
            'manage_options', // Capability
            'wppro-ada-settings', // Menu slug
            [$this, 'render_settings_page'], // Callback
            'dashicons-universal-access', // Icon
            60 // Position
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('wppro_ada_group', 'wppro_ada_settings', [
            'sanitize_callback' => [$this, 'sanitize_settings']
        ]);
    }

    /**
     * Handle settings save
     */
    public function handle_settings_save() {
        if (!isset($_POST['wppro_ada_save']) || !check_admin_referer('wppro_ada_nonce', 'wppro_ada_nonce_field')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        // Get current values
        $custom_js = isset($_POST['custom_js']) ? sanitize_textarea_field($_POST['custom_js']) : '';
        $custom_css = isset($_POST['custom_css']) ? sanitize_textarea_field($_POST['custom_css']) : '';
        $js_location = isset($_POST['js_location']) ? sanitize_text_field($_POST['js_location']) : 'head';

        // No empty check: allow empty values for custom_js and custom_css

        // Additional validation for JavaScript and CSS syntax
        if (!$this->validate_javascript($custom_js)) {
            add_settings_error(
                'wppro_ada_messages',
                'wppro_ada_error',
                'Error: Invalid JavaScript syntax. Please check your code.',
                'error'
            );
            set_transient('settings_errors', get_settings_errors(), 30);
            return;
        }

        if (!$this->validate_css($custom_css)) {
            add_settings_error(
                'wppro_ada_messages',
                'wppro_ada_error',
                'Error: Invalid CSS syntax. Please check your code.',
                'error'
            );
            set_transient('settings_errors', get_settings_errors(), 30);
            return;
        }

        // Save to database
        global $wpdb;

        $wpdb->update(
            $this->table_name,
            ['setting_value' => $custom_js],
            ['setting_name' => 'custom_js'],
            ['%s'],
            ['%s']
        );

        $wpdb->update(
            $this->table_name,
            ['setting_value' => $custom_css],
            ['setting_name' => 'custom_css'],
            ['%s'],
            ['%s']
        );

        $wpdb->update(
            $this->table_name,
            ['setting_value' => $js_location],
            ['setting_name' => 'js_location'],
            ['%s'],
            ['%s']
        );

        add_settings_error(
            'wppro_ada_messages',
            'wppro_ada_success',
            'Settings saved successfully.',
            'success'
        );

        set_transient('settings_errors', get_settings_errors(), 30);
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        if (is_array($input)) {
            return array_map('sanitize_textarea_field', $input);
        }
        return sanitize_textarea_field($input);
    }

    /**
     * Validate JavaScript
     */
    private function validate_javascript($code) {
        // Basic validation - check for balanced braces and parentheses
        $open_braces = substr_count($code, '{');
        $close_braces = substr_count($code, '}');
        $open_parens = substr_count($code, '(');
        $close_parens = substr_count($code, ')');

        return ($open_braces == $close_braces && $open_parens == $close_parens);
    }

    /**
     * Validate CSS
     */
    private function validate_css($code) {
        // Basic validation - check for balanced braces
        $open_braces = substr_count($code, '{');
        $close_braces = substr_count($code, '}');

        return ($open_braces == $close_braces);
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        global $wpdb;

        // Always enqueue the base CSS in the head
        wp_enqueue_style('wppro-ada-css', WPPRO_ADA_URL . 'css/ada.css');

        // Add custom CSS inline in the head if set
        $custom_css = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'custom_css'"
        );
        if ($custom_css) {
            wp_add_inline_style('wppro-ada-css', $custom_css);
        }

        // Always enqueue the base JS in the head
        wp_enqueue_script('wppro-ada-js', WPPRO_ADA_URL . 'js/ada.js', [], WPPRO_ADA_VERSION, false);

        // Add custom JS inline according to settings
        $custom_js = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'custom_js'"
        );
        $js_location = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'js_location'"
        );
        $in_footer = ($js_location === 'footer');
        if ($custom_js) {
            // If footer selected, enqueue a new script in footer
            if ($in_footer) {
                add_action('wp_footer', function() use ($custom_js) {
                    echo '<script>' . $custom_js . '</script>';
                });
            } else {
                // Otherwise, add inline script to ada.js in head
                wp_add_inline_script('wppro-ada-js', $custom_js, 'after');
            }
        }
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        global $wpdb;

        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        // Get current settings
        $custom_js = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'custom_js'"
        );
        $custom_css = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'custom_css'"
        );
        $js_location = $wpdb->get_var(
            "SELECT setting_value FROM {$this->table_name} WHERE setting_name = 'js_location'"
        );
        // Ensure values are always strings to avoid PHP 8.1+ deprecation warnings
        $custom_js = $custom_js ?? '';
        $custom_css = $custom_css ?? '';
        $js_location = $js_location ?? 'head';

        // Display settings
        settings_errors('wppro_ada_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <form method="post" action="">
                <?php wp_nonce_field('wppro_ada_nonce', 'wppro_ada_nonce_field'); ?>

                <!-- Custom CSS Section -->
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_css">Custom CSS</label>
                        </th>
                        <td>
                            <textarea
                                id="custom_css"
                                name="custom_css"
                                rows="10"
                                cols="50"
                                style="width: 100%; max-width: 800px; font-family: monospace;">
                                <?php echo esc_textarea($custom_css); ?>
                            </textarea>
                            <p class="description">
                                Enter custom CSS code. This will be loaded in &lt;style&gt; tags in the page head.
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Custom JavaScript Section -->
                <table class="form-table" style="margin-top: 20px;">
                    <tr valign="top">
                        <th scope="row">
                            <label>Load JavaScript in</label>
                        </th>
                        <td>
                            <fieldset>
                                <label>
                                    <input
                                        type="radio"
                                        name="js_location"
                                        value="head"
                                        <?php checked($js_location, 'head'); ?>
                                    />
                                    Head
                                </label>
                                <br />
                                <label>
                                    <input
                                        type="radio"
                                        name="js_location"
                                        value="footer"
                                        <?php checked($js_location, 'footer'); ?>
                                    />
                                    Footer
                                </label>
                            </fieldset>
                            <p class="description">
                                Select where to load the JavaScript file (Head is default).
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_js">Custom JavaScript</label>
                        </th>
                        <td>
                            <textarea
                                id="custom_js"
                                name="custom_js"
                                rows="10"
                                cols="50"
                                style="width: 100%; max-width: 800px; font-family: monospace;">
                                <?php echo esc_textarea($custom_js); ?>
                            </textarea>
                            <p class="description">
                                Enter custom JavaScript code. This will be wrapped in &lt;script&gt; tags.
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Save Button -->
                <div style="margin-top: 20px;">
                    <?php submit_button('Save Settings', 'primary', 'wppro_ada_save'); ?>
                </div>
            </form>
        </div>
        <?php
    }
}
