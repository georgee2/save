{{-- Floating Language Switcher --}}
<div class="language-switcher" id="languageSwitcher">
    <div class="switcher-toggle" id="switcherToggle">
        <i class="fas fa-globe"></i>
    </div>
    <div class="switcher-options">
        <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" 
           class="lang-option {{ app()->getLocale() == 'en' ? 'active' : '' }}"
           title="English">
            <span class="lang-flag">EN</span>
            <span class="lang-name">English</span>
        </a>
        <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" 
           class="lang-option {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
           title="العربية">
            <span class="lang-flag">ع</span>
            <span class="lang-name">العربية</span>
        </a>
    </div>
</div>

<style>
/* ===========================================
   Floating Language Switcher
   =========================================== */
.language-switcher {
    position: fixed;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    z-index: 9999992;
    display: flex;
    align-items: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

[dir="rtl"] .language-switcher {
    left: auto;
    right: 0;
}

/* Switcher Toggle Button */
.switcher-toggle {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
    border-radius: 0 12px 12px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 4px 0 20px rgba(25, 134, 139, 0.3);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

[dir="rtl"] .switcher-toggle {
    border-radius: 12px 0 0 12px;
    box-shadow: -4px 0 20px rgba(25, 134, 139, 0.3);
}

.switcher-toggle:hover {
    background: linear-gradient(135deg, #0d6b6f 0%, #19868b 100%);
    width: 55px;
}

.switcher-toggle i {
    color: #ffffff;
    font-size: 20px;
    transition: transform 0.3s ease;
}

.language-switcher.open .switcher-toggle i {
    transform: rotate(180deg);
}

/* Switcher Options Panel */
.switcher-options {
    position: absolute;
    left: 50px;
    top: 50%;
    transform: translateY(-50%) translateX(-20px);
    background: #ffffff;
    border-radius: 0 16px 16px 0;
    box-shadow: 8px 0 30px rgba(0, 0, 0, 0.15);
    padding: 8px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 140px;
}

[dir="rtl"] .switcher-options {
    left: auto;
    right: 50px;
    transform: translateY(-50%) translateX(20px);
    border-radius: 16px 0 0 16px;
    box-shadow: -8px 0 30px rgba(0, 0, 0, 0.15);
}

.language-switcher.open .switcher-options {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(-50%) translateX(0);
}

/* Language Option */
.lang-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    background: #f8fafc;
}

.lang-option:hover {
    background: linear-gradient(135deg, rgba(25, 134, 139, 0.1) 0%, rgba(25, 134, 139, 0.05) 100%);
    text-decoration: none;
    transform: translateX(5px);
}

[dir="rtl"] .lang-option:hover {
    transform: translateX(-5px);
}

.lang-option.active {
    background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
}

.lang-option.active:hover {
    transform: none;
}

/* Language Flag/Code */
.lang-flag {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border-radius: 50%;
    font-size: 14px;
    font-weight: 700;
    color: #1a1a2e;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.lang-option.active .lang-flag {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    box-shadow: none;
}

/* Language Name */
.lang-name {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a2e;
    white-space: nowrap;
}

.lang-option.active .lang-name {
    color: #ffffff;
}

/* Pulse Animation for Toggle */
.switcher-toggle::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    background: inherit;
    animation: pulse-ring 2s ease-out infinite;
    z-index: -1;
}

@keyframes pulse-ring {
    0% {
        transform: scale(1);
        opacity: 0.5;
    }
    100% {
        transform: scale(1.3);
        opacity: 0;
    }
}

/* Hide pulse when open */
.language-switcher.open .switcher-toggle::before {
    animation: none;
    opacity: 0;
}

/* Responsive */
@media (max-width: 767px) {
    .switcher-toggle {
        width: 44px;
        height: 44px;
    }
    
    .switcher-toggle i {
        font-size: 18px;
    }
    
    .switcher-options {
        left: 44px;
        min-width: 130px;
        padding: 6px;
    }
    
    [dir="rtl"] .switcher-options {
        left: auto;
        right: 44px;
    }
    
    .lang-option {
        padding: 10px 12px;
        gap: 10px;
    }
    
    .lang-flag {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .lang-name {
        font-size: 13px;
    }
}

/* Very small screens - move to bottom */
@media (max-width: 480px) {
    .language-switcher {
        top: auto;
        bottom: 100px;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const switcher = document.getElementById('languageSwitcher');
    const toggle = document.getElementById('switcherToggle');
    
    if (toggle && switcher) {
        // Toggle on click
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            switcher.classList.toggle('open');
        });
        
        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!switcher.contains(e.target)) {
                switcher.classList.remove('open');
            }
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                switcher.classList.remove('open');
            }
        });
    }
});
</script>


