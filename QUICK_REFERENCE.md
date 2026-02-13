# WPPRO ADA - Quick Reference Card

## 📌 Plugin Basics

**Name:** WPPRO ADA  
**Version:** 1.0.0  
**Location:** wp-content/plugins/wppro-ada/  
**Settings:** Settings → WPPRO ADA  

---

## 🎯 What This Plugin Does

1. Allows you to add **custom CSS** to your site
2. Allows you to add **custom JavaScript** to your site
3. Loads CSS in the page `<head>` section
4. Loads JavaScript in either `<head>` or `<footer>` (your choice)
5. Stores all settings safely in the database
6. Validates and sanitizes all code before saving
7. Protects plugin files from direct access

---

## 🔧 How to Use

### Access Settings
1. WordPress Admin Dashboard
2. Click **Settings** in left menu
3. Click **WPPRO ADA**

### Add Custom CSS
1. Scroll to **Custom CSS** field
2. Paste or type your CSS code
3. Click **Save Settings**

### Add Custom JavaScript
1. Choose where to load it:
   - **Head** = Load before page content
   - **Footer** = Load at end of page
2. Paste or type your JavaScript code
3. Click **Save Settings**

### Save
- Click **Save Settings** at bottom
- Green message = ✅ Success
- Red message = ❌ Error (check code)

---

## ⚙️ Settings Page Layout

```
┌─────────────────────────────────────┐
│         WPPRO ADA SETTINGS          │
├─────────────────────────────────────┤
│                                     │
│  CUSTOM CSS                         │
│  ┌─────────────────────────────┐   │
│  │  [Your CSS code here]       │   │
│  │  (10 rows, wraps to width)  │   │
│  └─────────────────────────────┘   │
│                                     │
│  LOAD JAVASCRIPT IN                 │
│  ○ Head  ○ Footer [with radio]      │
│                                     │
│  CUSTOM JAVASCRIPT                  │
│  ┌─────────────────────────────┐   │
│  │  [Your JS code here]        │   │
│  │  (10 rows, wraps to width)  │   │
│  └─────────────────────────────┘   │
│                                     │
│  [Save Settings] button             │
│                                     │
└─────────────────────────────────────┘
```

---

## ✅ Validation Rules

### All fields must have content
```
❌ Empty CSS field = Error
❌ Empty JS field = Error
✅ Both filled = Can save
```

### JavaScript must be valid
```
✅ JavaScript with { } and ( ) balanced = OK
❌ { count ≠ } count = Error message
❌ ( count ≠ ) count = Error message
```

### CSS must be valid
```
✅ CSS with { } balanced = OK
❌ { count ≠ } count = Error message
```

---

## 📝 Example Code

### Simple CSS Example
```css
body {
  font-size: 16px;
  line-height: 1.6;
}

a:focus {
  outline: 2px solid blue;
}
```

### Simple JavaScript Example
```javascript
(function() {
  console.log('Page loaded');
  
  // Your code here
})();
```

---

## 🗄️ Database Storage

**Table Name:** wp_wppro_ada_settings  
**Stored Values:**
- `custom_js` - Your JavaScript code
- `custom_css` - Your CSS code
- `js_location` - "head" or "footer"

---

## 🔐 Security Features

1. ✅ Code validated before saving
2. ✅ Code sanitized to remove harmful content
3. ✅ Files protected from direct access
4. ✅ Only admins can change settings
5. ✅ Database-safe storage (no SQL injection)
6. ✅ Nonce verification (prevents hacking)

---

## 🚫 File Formats

**Allowed:**
- Plain text CSS
- Plain text JavaScript
- Comments (both `/* */` and `//`)

**Not Allowed:**
- External file imports
- `<style>` or `<script>` tags (plugin adds them)
- PHP code (will be stripped)
- HTML (will be stripped)

---

## 📂 Folder Structure

```
wppro-ada/
├── wppro-ada.php          ← Main plugin file
├── includes/
│   └── class-wppro-ada.php  ← Core functionality
├── js/
│   └── ada.js              ← Base JS file
├── css/
│   └── ada.css             ← Base CSS file
└── [Security files]
    ├── .htaccess           ← Apache security
    ├── web.config          ← IIS security
    └── index.php           ← Directory protection
```

---

## 🎓 Common Tasks

### Task: Add Font Size Change
```css
body {
  font-size: 18px;
}
```
Save → Done!

### Task: Add Skip Link
```css
.skip-link {
  position: absolute;
  left: -9999px;
}

.skip-link:focus {
  left: 0;
}
```
And JavaScript:
```javascript
var skipLink = document.querySelector('.skip-link');
if(skipLink) {
  skipLink.href = '#main-content';
}
```

### Task: Add Keyboard Navigation Event
```javascript
(function() {
  document.addEventListener('keydown', function(e) {
    if(e.key === 'Tab') {
      document.body.classList.add('keyboard-mode');
    }
  });
})();
```

---

## 🆘 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| Settings won't save | Check all fields are filled |
| JS validation error | Count `{` and `}` - must match |
| CSS validation error | Count `{` and `}` - must match |
| Changes don't show | Clear browser cache (Ctrl+Shift+Del) |
| Settings page missing | Verify plugin is activated |
| Files accessible via URL | Check .htaccess is uploaded |

---

## 📊 Performance Impact

- **Page Size Increase:** Minimal (depends on your code)
- **Load Time:** < 10ms typically
- **Database Queries:** 1-2 extra queries
- **Memory Usage:** < 1MB

---

## 🔄 When to Use

✅ **Use this plugin for:**
- Accessibility improvements
- Custom fonts or colors
- Keyboard navigation enhancements
- ADA compliance
- User experience improvements

❌ **Don't use for:**
- Complex website logic (use different plugins)
- Security-sensitive code (sanitizes output)
- Visual page builders (use builder instead)

---

## 📚 Where to Find More Info

| Document | Content |
|----------|---------|
| README.md | Full documentation |
| QUICK_START.md | Full getting started guide |
| FEATURES.md | Technical details |
| DEPLOYMENT.md | Installation guide |
| FILE_MANIFEST.md | File descriptions |

---

## 🎯 Key Takeaways

1. **Access:** Settings → WPPRO ADA
2. **Add CSS/JS:** Paste code in textfields
3. **Choose JS location:** Head or Footer
4. **Save:** Click "Save Settings"
5. **Validate:** All fields filled + valid syntax
6. **Secure:** Files protected, code sanitized

---

## 💡 Pro Tips

1. **Test first** - Write code in browser console before pasting
2. **Use comments** - Help future you understand the code
3. **Keep simple** - Small focused code is safer
4. **Backup** - Copy your code somewhere before updating
5. **Monitor** - Check browser console for errors after saving

---

## ⚡ Keyboard Shortcuts

In WordPress Admin:
- `Ctrl + S` - Save (works if Save button is focused)
- `Tab` - Move between fields
- `Enter` - Activate buttons/radio

---

**Version:** 1.0.0  
**Last Updated:** February 13, 2026  
**For:** WPPRO ADA Plugin
