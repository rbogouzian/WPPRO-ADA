# WPPRO ADA - Quick Start Guide

## What is WPPRO ADA?

WPPRO ADA is a WordPress plugin designed to help you implement ADA (Americans with Disabilities Act) compliance features on your website. It provides a simple admin interface where you can add custom CSS and JavaScript code with flexible loading options.

## Installation Steps

### Step 1: Upload the Plugin
1. Download the `wppro-ada` folder
2. Use FTP or your hosting control panel's file manager
3. Navigate to: `wp-content/plugins/`
4. Upload the entire `wppro-ada` folder here

### Step 2: Activate the Plugin
1. Log in to your WordPress admin dashboard
2. Go to **Plugins** in the left sidebar
3. Look for "WPPRO ADA" in the plugin list
4. Click **Activate**
5. The plugin will create the necessary database table automatically

### Step 3: Access Plugin Settings
1. In WordPress admin, go to **Settings** → **WPPRO ADA**
2. You now have access to the plugin settings page

## Using the Plugin

### Adding Custom CSS

1. Go to **Settings** → **WPPRO ADA**
2. In the "Custom CSS" section, enter your CSS code
3. Example:
   ```css
   body {
       font-size: 16px;
       line-height: 1.6;
   }
   
   a:focus {
       outline: 2px solid blue;
   }
   ```
4. The CSS will be automatically wrapped in `<style>` tags and loaded in the page head

### Adding Custom JavaScript

1. Go to **Settings** → **WPPRO ADA**
2. First, choose where to load JavaScript using the radio buttons:
   - **Head** (default): Loads before page content
   - **Footer**: Loads at the end of the page
3. Example JavaScript:
   ```javascript
   (function() {
       console.log('ADA plugin loaded');
       // Your code here
   })();
   ```
4. The JavaScript will be automatically wrapped in `<script>` tags

### Saving Your Changes

1. After entering your CSS and JavaScript code
2. Click the **Save Settings** button at the bottom
3. You'll see a success message if everything is correct
4. If there's an error, check that:
   - All fields are filled in
   - Braces and parentheses are balanced
   - There are no syntax errors

## What Each File does

| File | Purpose |
|------|---------|
| `wppro-ada.php` | Main plugin file - manages loading and activation |
| `includes/class-wppro-ada.php` | Core plugin class - handles database, settings, and admin page |
| `js/ada.js` | Base ADA JavaScript file loaded on the frontend |
| `css/ada.css` | Base ADA CSS file loaded on the frontend |
| `.htaccess` | Prevents direct access to plugin files (Apache servers) |
| `web.config` | Prevents direct access to plugin files (IIS servers) |

## Security Features

✓ **Files cannot be accessed directly** - Typing the URL to a plugin file will show nothing (e.g., `yoursite.com/wp-content/plugins/wppro-ada/js/ada.js` won't load)

✓ **Input validation** - The plugin checks that:
- All required fields have content
- JavaScript has properly balanced braces `{}` and parentheses `()`
- CSS has properly balanced braces `{}`

✓ **Input sanitization** - The plugin cleans the code before saving to remove any potentially harmful content

✓ **WordPress security** - Uses nonces (security tokens) to prevent unauthorized submissions

## Database Storage

All your settings are stored in a dedicated WordPress database table: `wp_wppro_ada_settings`

This table stores:
- Custom CSS code
- Custom JavaScript code
- JavaScript load location (head or footer)

## Troubleshooting

### "Settings saved successfully" - but changes don't appear

**Solution:**
- Clear your browser cache (Ctrl+Shift+Del)
- Clear any WordPress caching plugins
- Check browser console for JavaScript errors (F12)

### Getting validation errors

**JavaScript validation error:**
- Check that all `{` have closing `}`
- Check that all `(` have closing `)`
- Look for unclosed quotes or semicolons

**CSS validation error:**
- Check that all `{` have closing `}`
- Look for syntax errors in your selectors

### Plugin doesn't activate

**Solution:**
- Check your PHP version (WordPress requires PHP 5.6+)
- Ensure you have file write permissions on the database
- Check that `wp-content/plugins/` folder is writable

### Changes not showing on frontend

**Solution:**
- Ensure you clicked "Save Settings"
- Check that the code was actually saved in the settings
- Verify the code doesn't have JavaScript errors
- Try accessing the site from an incognito/private browsing window

## Best Practices

1. **Test your code first** - Write and test CSS/JS in your browser console before pasting
2. **Keep code simple** - Avoid complex logic that might break other plugins
3. **Use consistent formatting** - Makes it easier to edit later
4. **Add comments** - Explain what your code does
5. **Backup your settings** - Make a copy of your code before updating

## Example: Basic ADA Improvements

### Example CSS:
```css
/* Improve focus visibility */
a:focus,
button:focus,
input:focus {
    outline: 3px solid #4A90E2;
    outline-offset: 2px;
}

/* Skip link */
.skip-link {
    position: absolute;
    left: -9999px;
    z-index: 999;
}

.skip-link:focus {
    left: 0;
    top: 0;
}
```

### Example JavaScript:
```javascript
(function() {
    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });
    
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-nav');
    });
})();
```

## Support & More Info

For updates and additional documentation, visit the README.md file in the plugin folder.

## Version Info

- **Current Version**: 1.0.0
- **Last Updated**: 2026
- **License**: GPL2

---

**Need help?** Make sure all fields are filled, code is syntactically correct, and try saving again!
