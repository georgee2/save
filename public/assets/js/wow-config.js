/**
 * WOW.js Configuration
 * Optimized for reduced eye strain and better performance
 */

// Override default WOW.js settings for smoother, less tiring animations
(function() {
    // Store original WOW init
    if (typeof WOW !== 'undefined') {
        const originalWOWInit = WOW.prototype.init;
        
        // Override WOW initialization with optimized settings
        WOW.prototype.init = function() {
            // Apply optimized default settings
            this.config = Object.assign({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 80, // Reduced from default 0 - trigger animations earlier
                mobile: true,
                live: true,
                scrollContainer: null,
                resetAnimation: false // Don't repeat animations on scroll up
            }, this.config || {});
            
            // Call original init
            return originalWOWInit.call(this);
        };
    }
    
    // Reduce animation duration globally via CSS custom properties
    document.addEventListener('DOMContentLoaded', function() {
        // Add custom animation duration to root
        document.documentElement.style.setProperty('--animate-duration', '0.6s');
        
        // Optimize all WOW elements
        const wowElements = document.querySelectorAll('.wow');
        wowElements.forEach(function(element) {
            // Ensure faster animation duration
            if (!element.style.animationDuration) {
                element.style.animationDuration = '0.6s';
            }
            
            // Use smoother easing
            if (!element.style.animationTimingFunction) {
                element.style.animationTimingFunction = 'cubic-bezier(0.4, 0, 0.2, 1)';
            }
            
            // Add will-change for better performance
            element.style.willChange = 'transform, opacity';
            
            // Remove will-change after animation completes
            element.addEventListener('animationend', function() {
                this.style.willChange = 'auto';
            }, { once: true });
        });
    });
    
    // Optimize animation delays
    window.addEventListener('load', function() {
        const style = document.createElement('style');
        style.textContent = `
            /* Optimized WOW.js animation delays */
            .wow {
                animation-duration: 0.6s !important;
                animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            /* Reduce delay between sequential animations */
            .wow:nth-child(1) { animation-delay: 0s !important; }
            .wow:nth-child(2) { animation-delay: 0.1s !important; }
            .wow:nth-child(3) { animation-delay: 0.2s !important; }
            .wow:nth-child(4) { animation-delay: 0.3s !important; }
            .wow:nth-child(5) { animation-delay: 0.4s !important; }
            .wow:nth-child(n+6) { animation-delay: 0.5s !important; }
            
            /* Faster fade animations */
            .fadeIn { animation-duration: 0.5s !important; }
            .fadeInUp { animation-duration: 0.5s !important; }
            .fadeInDown { animation-duration: 0.5s !important; }
            .fadeInLeft { animation-duration: 0.5s !important; }
            .fadeInRight { animation-duration: 0.5s !important; }
            
            /* Reduce bounce intensity */
            @keyframes bounceIn {
                from, 20%, 40%, 60%, 80%, to {
                    animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                }
                0% {
                    opacity: 0;
                    transform: scale3d(.8, .8, .8);
                }
                20% {
                    transform: scale3d(1.05, 1.05, 1.05);
                }
                40% {
                    transform: scale3d(.95, .95, .95);
                }
                60% {
                    opacity: 1;
                    transform: scale3d(1.02, 1.02, 1.02);
                }
                80% {
                    transform: scale3d(.98, .98, .98);
                }
                to {
                    opacity: 1;
                    transform: scale3d(1, 1, 1);
                }
            }
        `;
        document.head.appendChild(style);
    });
})();

