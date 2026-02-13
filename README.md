# WPPRO ADA - WordPress Plugin

## Description
WPPRO ADA is a WordPress plugin that dynamically detects and resolves many of the most common accessibility issues found on WordPress websites. It automatically enhances elements such as images, forms, navigation menus, color contrast, and interactive components to improve usability for people with disabilities, helping your site align with ADA (Americans with Disabilities Act) standards with minimal manual effort.

In addition, WPPRO ADA allows you to inject custom CSS and JavaScript with flexible loading options, giving you full control over how and when accessibility enhancements are applied. All plugin settings are securely stored in the WordPress database for easy management and configuration.

## Features
- **Database Storage**: All settings are stored in custom database tables
- **Custom CSS**: Add custom CSS code with inline style tag loading in the page head
- **Custom JavaScript**: Add custom JavaScript with options to load in head or footer
- **Flexible JS Loading**: Choose whether to load JavaScript in the page head (default) or footer
- **Input Validation**: All inputs are validated and sanitized before saving
- **Security**: Protects files from direct access through .htaccess and index.php guards
- **Easy Admin Interface**: Simple settings page in WordPress admin panel

## Installation

### Manual Installation
1. Download or clone the plugin files
2. Navigate to your WordPress installation directory: `wp-content/plugins/`
3. Upload the `wppro-ada` folder to the plugins directory
4. Log in to WordPress admin panel
5. Go to **Plugins** and find "WPPRO ADA"
6. Click **Activate** to activate the plugin

### Automatic Activation
- Upon activation, the plugin will automatically:
  - Create a custom database table (`wp_wppro_ada_settings`)
  - Initialize default settings for CSS, JavaScript, and load location

## Usage

### Plugin Settings Page
1. Go to **Settings** > **WPPRO ADA** in the WordPress admin panel
2. You will see the following options:

#### Custom CSS Section
- Enter your custom CSS code in the textarea
- CSS will be wrapped in `<style>` tags and loaded in the page head
- The code is sanitized before saving

#### Custom JavaScript Section
- **Load JavaScript in**: Choose between Head or Footer (default: Head)
  - **Head**: JavaScript loads in the page head before content renders
  - **Footer**: JavaScript loads at the end of the page body before closing tag

- Enter your custom JavaScript code in the textarea
- The code is wrapped in `<script>` tags and loaded based on your selection
- The code is sanitized before saving

#### Save
- Click the **Save Settings** button at the bottom to save your changes
- A success or error message will display after saving

## Database Tables

### wp_wppro_ada_settings
Stores all plugin settings with the following columns:
- `id`: Record ID (Primary Key)
- `setting_name`: Name of the setting (custom_js, custom_css, js_location)
- `setting_value`: Value of the setting (longtext field)
- `created_at`: Timestamp when the setting was created
- `updated_at`: Timestamp when the setting was last updated

## File Structure
```
wppro-ada/
├── wppro-ada.php              # Main plugin file
├── .htaccess                  # Apache protection rules
├── index.php                  # Directory access prevention
├── includes/
│   ├── class-wppro-ada.php    # Main plugin class
│   └── index.php              # Directory access prevention
├── js/
│   ├── ada.js                 # ADA JavaScript file
│   └── index.php              # Directory access prevention
└── css/
    ├── ada.css                # ADA CSS file
    └── index.php              # Directory access prevention
```

## Security Features

### Input Validation
- All textfield inputs are validated before saving
- JavaScript code is checked for balanced braces and parentheses
- CSS code is checked for balanced braces
- All inputs are sanitized using WordPress sanitization functions

### Access Protection
- Plugin files cannot be accessed directly via URL
- `.htaccess` rules prevent directory listing and direct file access
- `index.php` files in each directory provide additional protection
- WordPress `ABSPATH` check ensures code only runs in WordPress context

## Version
1.0.0

## License
GPL2

## Support
For support and updates, please visit: https://example.com

## Changelog

### Version 1.0.0
- Initial release
- Custom CSS support with inline style tag loading
- Custom JavaScript support with head/footer loading options
- Database table creation and management
- Admin settings page with validation and sanitization
- Security features to prevent direct file access
