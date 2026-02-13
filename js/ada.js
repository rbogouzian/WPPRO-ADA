/**
 * WPPRO ADA - Main JavaScript File
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // ADA Compliance Features
    const WPPRO_ADA = {
        init: function() {
            console.log('WPPRO ADA Plugin Loaded');
            this.setupAccessibility();
        },

        setupAccessibility: function() {
            // Add accessibility features here
            this.addSkipLinks();
            this.pageLoaded();
        },

        addSkipLinks: function() {
            // Implementation for skip links
        },

        

        pageLoaded: function() {
            // Implementation for page load events
            var meta = document.querySelector('meta[name="viewport"]');

            // If the meta tag exists
            if (meta) {
                // Parse the content of the viewport meta tag
                var content = meta.getAttribute('content');
                
                // Replace disallowed scaling settings if they exist
                content = content.replace(/user-scalable\s*=\s*no/i, 'user-scalable=yes');
                content = content.replace(/user-scalable\s*=\s*0/i, 'user-scalable=yes');
                content = content.replace(/maximum-scale\s*=\s*[\d\.]+/i, 'maximum-scale=2.0');
                
                // Update the viewport meta tag's content attribute
                meta.setAttribute('content', content);
            } else {
                // If no viewport meta tag exists, create one with proper settings
                meta = document.createElement('meta');
                meta.name = 'viewport';
                meta.content = 'width=device-width, initial-scale=1, user-scalable=yes, maximum-scale=2.0';
                document.getElementsByTagName('head')[0].appendChild(meta);
            }
            
            
        document.querySelectorAll('a').forEach(link => {
            // Skip non-interactive or hidden links
            if (link.offsetParent === null) return;

            // Determine the visible label text
            const visibleText = link.textContent.trim();
            const fallbackText = visibleText || link.title || link.href;

            console.log("link: " + link.href);
            if (!fallbackText) {
            console.warn('⚠️ Empty link missing accessible name:', link);
            return;
            }

            // CASE 1: aria-label does NOT exist → create it
            if (!link.hasAttribute('aria-label')) {
            link.setAttribute('aria-label', fallbackText);
            return;
            }

            // CASE 2: aria-label exists → check if it contains visible text
            const ariaLabel = link.getAttribute('aria-label');

            // If aria-label does NOT include the visible label, append it
            if (fallbackText && !ariaLabel.toLowerCase().includes(fallbackText.toLowerCase())) {
                const newLabel = ariaLabel + ' ' + fallbackText;
                link.setAttribute('aria-label', newLabel.trim());
            }
            

        });


            /*ADD VIDEO DESCRIPTION TO THE BACKGROUND VIDEO*/
            document.querySelectorAll('.slider-video').forEach((svdo, sI ) => {
                svdo.setAttribute('aria-label', 'Blue sky with clouds moving slowly.');
            });
       

        document.querySelectorAll('button').forEach(btn => {
            if (btn.offsetParent === null) return; // Skip hidden/inert buttons

            const visibleText = (btn.textContent || '').trim();
            const ariaLabel = (btn.getAttribute('aria-label') || '').trim();

            if (!ariaLabel && visibleText) {
            // Case 1: No aria-label → set it to visible text
            btn.setAttribute('aria-label', visibleText);

            } else if (visibleText && ariaLabel && !ariaLabel.toLowerCase().includes(visibleText.toLowerCase())) {
            // Case 2: aria-label and visible text differ → merge both
            // Ensures screen readers announce consistent meaning.
                const newbtnLabel = ariaLabel + ' ' + visibleText;
            btn.setAttribute('aria-label', newbtnLabel.trim());
            }
        });
            
            document.querySelectorAll('[aria-hidden="true"]').forEach(hidEl => {
                console.log('found element');
                // 1. The container itself should not be focusable
                if (hidEl.tabIndex >= 0) {
                    hidEl.setAttribute('tabindex', '-1');
                }

                // 2. Remove focusability from child interactive elements
                const focusableSelectors = [
                    'a[href]',
                    'button',
                    'input',
                    'select',
                    'textarea',
                    'div',
                    '[tabindex]',
                    '[role="button"]',
                    '[role="link"]'
                ];

                hidEl.querySelectorAll(focusableSelectors.join(',')).forEach(child => {
                    child.setAttribute('tabindex', '-1');
                    child.setAttribute('disabled', true); // optional but stronger
                    child.setAttribute('aria-disabled', 'true');
                });
        });
            


            /*Find all the images without alt or emply alt and add the image name as value*/
            
            document.querySelectorAll('img').forEach(img => {
                const currentAlt = img.getAttribute('alt');

                // If alt exists and has a value, skip it
                if (currentAlt && currentAlt.trim() !== '') return;

                const src = img.getAttribute('src');
                if (!src) return;

                // Extract filename from the src
                const fileName = src.substring(src.lastIndexOf('/') + 1, src.lastIndexOf('.'));

                if (!fileName) return;

                // Replace dashes, underscores, and hyphens with spaces
                const cleaned = fileName.replace(/[-_]+/g, ' ').trim();

                // Assign as alt text
                img.setAttribute('alt', cleaned);
            });
	


        }
    };

    // Initialize on document ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            WPPRO_ADA.init();
        });
    } else {
        WPPRO_ADA.init();
    }

    // Expose to global scope if needed
    window.WPPROADAL = WPPRO_ADA;
})();
