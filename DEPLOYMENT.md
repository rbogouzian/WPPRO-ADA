# WPPRO ADA - Deployment & Installation Guide

## 🚀 Quick Deployment Steps

### For Local WordPress Installation

#### Step 1: Copy Plugin Files
```
Source: c:\Users\e707027\Documents\Projects\ISD-IDD-ADA-remediation\wppro-ada
Destination: C:\path\to\your\wordpress\wp-content\plugins\wppro-ada
```

Use Windows Explorer or command line:
```powershell
Copy-Item -Path "c:\Users\e707027\Documents\Projects\ISD-IDD-ADA-remediation\wppro-ada" `
          -Destination "C:\path\to\wordpress\wp-content\plugins\" `
          -Recurse -Force
```

#### Step 2: Ensure Permissions
- Make sure WordPress can read/write to the plugin directory
- Permissions needed: Read, Write, Execute for web server

#### Step 3: Activate Plugin
1. Log in to WordPress Admin Dashboard
2. Navigate to **Plugins** menu
3. Find **WPPRO ADA** in the plugin list
4. Click **Activate Button**
5. Wait for database table creation

#### Step 4: Verify Installation
1. Go to **Settings** menu
2. Look for **WPPRO ADA** option
3. Click to open settings page
4. Should see custom CSS and JavaScript fields
5. Save a test message to confirm it works

---

### For Shared Hosting/cPanel

#### Step 1: Upload via FTP
1. Connect to your server via FTP client (FileZilla, WinSCP, etc.)
2. Navigate to: `/public_html/wp-content/plugins/`
3. Upload the entire `wppro-ada` folder
4. Ensure file permissions are set to 644 for files, 755 for directories

#### Step 2: Verify Upload
- Check that all files are present
- Confirm file permissions (644/755)
- Verify .htaccess file is uploaded

#### Step 3: Activate in Dashboard
1. Log in to WordPress admin
2. Go to **Plugins**
3. Activate **WPPRO ADA**
4. Check **Settings > WPPRO ADA** to verify

#### Step 4: Database Setup
- Plugin automatically creates the database table
- Check that no errors appear during activation
- Database table: `wp_wppro_ada_settings`

---

### For WordPress.com / Managed Hosting

#### Note: May not be compatible with:
- WordPress.com (no plugin uploads allowed)
- Heavily restricted managed hosting
- Hosts with disabled file access

#### Check if allowed:
1. Try accessing **Plugins > Add New > Upload Plugin**
2. If upload button is unavailable, plugins may not be supported
3. Contact hosting provider for plugin installation options

---

## 📋 Pre-Deployment Checklist

### Before Installing
- [ ] WordPress is installed and running (4.0+)
- [ ] You have admin access to WordPress
- [ ] PHP version is 5.6 or higher
- [ ] MySQL/MariaDB is accessible
- [ ] wp-content/plugins directory exists and is writable
- [ ] Backup of WordPress has been made
- [ ] No conflicting plugins with same functionality

### Server Requirements
```
Minimum:
- WordPress 4.0+
- PHP 5.6+
- MySQL 5.0+ or MariaDB 5.5+
- 2 MB disk space

Recommended:
- WordPress 5.0+
- PHP 7.2+
- MySQL 5.7+ or MariaDB 10.2+
- 5 MB disk space
```

---

## 🔍 Post-Installation Verification

### Check Database
Use phpMyAdmin or command line:
```sql
SELECT * FROM wp_wppro_ada_settings;
```

Should show 3 default records:
- custom_js (empty)
- custom_css (empty)
- js_location (head)

### Test the Plugin
1. Go to **Settings > WPPRO ADA**
2. Enter test CSS:
   ```css
   body {
       background: #f5f5f5;
   }
   ```
3. Enter test JavaScript:
   ```javascript
   console.log('WPPRO ADA Loaded');
   ```
4. Select "Head" for JavaScript location
5. Click "Save Settings"
6. Should see "Settings saved successfully" message

### Verify Frontend
1. Visit your website frontend
2. Right-click and "View Page Source"
3. Search for "WPPRO ADA" 
4. Should see CSS in `<style>` tags
5. Should see JavaScript in `<script>` tags
6. Check browser console (F12) for JavaScript messages

---

## 🛠️ Troubleshooting During Installation

### Problem: "Plugin could not be activated"

**Solutions:**
1. Check PHP version in hosting control panel
2. Verify wp-content/plugins is writable
3. Check PHP error logs for specific errors
4. Try deactivating other plugins first
5. Increase PHP memory limit in wp-config.php:
   ```php
   define('WP_MEMORY_LIMIT', '256M');
   ```

### Problem: "Database table not created"

**Solutions:**
1. Verify database user has CREATE TABLE permissions
2. Check database prefix in wp-config.php
3. Look at WordPress debug log for errors
4. Manually create table (see below)

**Manual Table Creation:**
```sql
CREATE TABLE IF NOT EXISTS wp_wppro_ada_settings (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    setting_name varchar(100) NOT NULL,
    setting_value longtext NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY setting_name (setting_name)
);

INSERT INTO wp_wppro_ada_settings VALUES
(1, 'custom_js', '', NOW(), NOW()),
(2, 'custom_css', '', NOW(), NOW()),
(3, 'js_location', 'head', NOW(), NOW());
```

### Problem: "Settings page not appearing"

**Solutions:**
1. Clear WordPress cache (if using caching plugin)
2. Deactivate caching plugins temporarily
3. Check that user has 'manage_options' capability
4. Verify plugin files are complete
5. Check for PHP syntax errors in logs

### Problem: "CSS/JS not loading on frontend"

**Solutions:**
1. Verify settings were actually saved
2. Check database using SELECT query
3. Clear browser cache (Ctrl+Shift+Del)
4. Check browser console for errors (F12)
5. Verify hook priorities don't conflict
6. Check that wp_enqueue_scripts is being called

### Problem: "Files showing as directly accessible"

**Solutions:**
1. Check .htaccess file exists in root
2. Verify Apache mod_rewrite is enabled
3. If IIS, check web.config exists and is valid
4. For shared hosts, verify .htaccess is allowed
5. Contact hosting provider if blocked

---

## 📚 File Deployment Checklist

### Required Files to Deploy
```
✓ wppro-ada.php                    (CRITICAL - Main file)
✓ .htaccess                        (Security)
✓ web.config                       (IIS Security)
✓ index.php                        (Root protection)

✓ includes/
  ✓ class-wppro-ada.php           (CRITICAL - Core class)
  ✓ index.php                      (Protection)

✓ js/
  ✓ ada.js                        (Frontend script)
  ✓ index.php                      (Protection)

✓ css/
  ✓ ada.css                       (Frontend styles)
  ✓ index.php                      (Protection)

✓ README.md                        (Documentation - optional)
✓ QUICK_START.md                   (Documentation - optional)
✓ FEATURES.md                      (Documentation - optional)
```

### Optional Documentation Files
- README.md
- QUICK_START.md
- FEATURES.md
- FILE_MANIFEST.md
- REQUIREMENTS_CHECKLIST.md
- DEPLOYMENT.md (this file)

**Note:** Documentation files don't affect functionality but help users understand the plugin.

---

## 🔐 Security Verification

After installation, verify security:

### 1. Test File Access Protection
```
Try accessing in browser:
❌ yoursite.com/wp-content/plugins/wppro-ada/wppro-ada.php
❌ yoursite.com/wp-content/plugins/wppro-ada/js/ada.js
❌ yoursite.com/wp-content/plugins/wppro-ada/css/ada.css

Should show:
- Blank page or 403 Forbidden
- NOT the actual file contents
```

### 2. Test Database Security
```sql
-- Check table exists
SHOW TABLES LIKE 'wp_wppro_ada_settings';

-- Check data is saved correctly
SELECT * FROM wp_wppro_ada_settings;

-- Verify no sensitive data is exposed
```

### 3. Test Admin Security
- Try accessing settings without being logged in
- Should redirect to login page
- Non-admin users should not see WPPRO ADA menu

---

## 📊 Performance Monitoring

### After Deployment, Monitor:

1. **Page Load Time**
   - Measure before and after installation
   - Should have minimal impact (< 10ms)

2. **Database Queries**
   - Plugin adds 1-2 queries per page load
   - Check with Debug Bar plugin

3. **Error Logs**
   - Watch `wp-content/debug.log` for errors
   - Enable debug mode temporarily if needed:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   ```

4. **Memory Usage**
   - Plugin uses minimal memory (< 1MB)
   - Check if causing memory limit issues

---

## 🎯 Next Steps After Deployment

1. **Configure Settings**
   - Add custom CSS for your site
   - Add custom JavaScript if needed
   - Test with visitors using assistive devices

2. **Test Accessibility**
   - Use accessibility checkers
   - Test with keyboard navigation
   - Test with screen readers

3. **Monitor Performance**
   - Check page load times
   - Monitor error logs
   - Get user feedback

4. **Keep Updated**
   - Check for plugin updates
   - Keep WordPress updated
   - Keep PHP updated

---

## 📞 Support & Resources

### Documentation Files
1. **README.md** - Complete plugin documentation
2. **QUICK_START.md** - User-friendly getting started
3. **FEATURES.md** - Technical specifications
4. **FILE_MANIFEST.md** - File descriptions

### WordPress Resources
- [WordPress.org Plugins](https://wordpress.org/plugins/)
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Hooks Reference](https://developer.wordpress.org/plugins/hooks/)

### ADA Compliance
- [W3C Web Accessibility](https://www.w3.org/WAI/)
- [ADA Guidelines](https://www.ada.gov/resources/web-accessibility/)
- [WCAG 2.1 Standards](https://www.w3.org/WAI/WCAG21/quickref/)

---

## ✅ Deployment Completion Checklist

- [ ] Plugin files copied to wp-content/plugins/wppro-ada/
- [ ] File permissions set correctly (644/755)
- [ ] Plugin activated in WordPress admin
- [ ] Database table created successfully
- [ ] Settings page accessible at Settings > WPPRO ADA
- [ ] Test CSS/JavaScript saved successfully
- [ ] CSS/JavaScript visible in page source
- [ ] Files not directly accessible via URL
- [ ] No error messages in WordPress dashboard
- [ ] Documentation reviewed by user

---

**Date**: February 13, 2026  
**Version**: 1.0.0  
**Plugin**: WPPRO ADA  
**Status**: Ready for Deployment
