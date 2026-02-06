@php
    use App\Models\AboutInformation;
    use App\Models\ContactInformation;
    use App\Models\Partner;
    
    // Get data with error handling
    try {
        $aboutInfo = AboutInformation::getAboutInfo();
        $contactInfo = ContactInformation::getContactInfo();
        $branches = Partner::getBranches();
    } catch (\Exception $e) {
        $aboutInfo = null;
        $contactInfo = null;
        $branches = collect();
    }
    
    $locale = app()->getLocale() ?? 'en';
    $isRtl = $locale === 'ar';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('lang.under_construction') !== 'lang.under_construction' ? __('lang.under_construction') : 'Under Construction' }} | Smart Vision</title>
    <link rel="icon" href="{{ asset('pic/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #19868b;
            --primary-dark: #0d6b6f;
            --secondary: #e1273e;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            --gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-xl: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: {{ $isRtl ? "'Tajawal', sans-serif" : "'Outfit', sans-serif" }};
            background: var(--gradient-dark);
            min-height: 100vh;
            color: var(--white);
            overflow-x: hidden;
            direction: {{ $isRtl ? 'rtl' : 'ltr' }};
        }

        /* Animated Background */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 15s infinite ease-in-out;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; animation-duration: 20s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; animation-duration: 18s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; animation-duration: 22s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 1s; animation-duration: 16s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 3s; animation-duration: 19s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; animation-duration: 21s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 2s; animation-duration: 17s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 4s; animation-duration: 23s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 1s; animation-duration: 18s; }
        .particle:nth-child(10) { left: 95%; animation-delay: 3s; animation-duration: 20s; }

        @keyframes float {
            0%, 100% { transform: translateY(100vh) scale(1); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) scale(1.5); opacity: 0; }
        }

        /* Geometric Shapes */
        .geo-shape {
            position: fixed;
            opacity: 0.05;
            z-index: 0;
        }

        .geo-shape-1 {
            top: 10%;
            right: 5%;
            width: 300px;
            height: 300px;
            border: 2px solid var(--primary);
            border-radius: 50%;
            animation: rotate 30s linear infinite;
        }

        .geo-shape-2 {
            bottom: 10%;
            left: 5%;
            width: 200px;
            height: 200px;
            border: 2px solid var(--secondary);
            transform: rotate(45deg);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: rotate(45deg) scale(1); }
            50% { transform: rotate(45deg) scale(1.1); }
        }

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 30px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 60px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .lang-switch {
            display: flex;
            gap: 10px;
        }

        .lang-btn {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: var(--white);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .lang-btn:hover, .lang-btn.active {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Hero Section - Enhanced Design */
        .hero {
            min-height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 50px 60px;
            position: relative;
            overflow: hidden;
        }

        /* Hero Background Effects */
        .hero-bg-gradient {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(25, 134, 139, 0.15) 0%, transparent 70%);
            pointer-events: none;
            animation: heroGradientPulse 8s ease-in-out infinite;
        }

        @keyframes heroGradientPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
        }

        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }

        .hero-orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(25, 134, 139, 0.4) 0%, rgba(13, 107, 111, 0.2) 100%);
            top: 10%;
            {{ $isRtl ? 'left' : 'right' }}: -100px;
            animation: orbFloat1 12s ease-in-out infinite;
        }

        .hero-orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(225, 39, 62, 0.3) 0%, rgba(180, 30, 50, 0.15) 100%);
            bottom: 10%;
            {{ $isRtl ? 'right' : 'left' }}: -50px;
            animation: orbFloat2 10s ease-in-out infinite;
        }

        .hero-orb-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.3) 0%, rgba(217, 119, 6, 0.15) 100%);
            top: 60%;
            {{ $isRtl ? 'left' : 'right' }}: 20%;
            animation: orbFloat3 14s ease-in-out infinite;
        }

        @keyframes orbFloat1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(-30px, 30px) rotate(120deg); }
            66% { transform: translate(20px, -20px) rotate(240deg); }
        }

        @keyframes orbFloat2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(40px, -30px) rotate(180deg); }
        }

        @keyframes orbFloat3 {
            0%, 100% { transform: translate(0, 0); }
            25% { transform: translate(-20px, 20px); }
            50% { transform: translate(20px, 40px); }
            75% { transform: translate(30px, -10px); }
        }

        /* Animated Lines */
        .hero-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero-line {
            position: absolute;
            width: 1px;
            height: 100%;
            background: linear-gradient(180deg, transparent, rgba(25, 134, 139, 0.3), transparent);
            animation: lineMove 8s linear infinite;
        }

        .hero-line:nth-child(1) { left: 10%; animation-delay: 0s; }
        .hero-line:nth-child(2) { left: 30%; animation-delay: 2s; }
        .hero-line:nth-child(3) { left: 50%; animation-delay: 4s; }
        .hero-line:nth-child(4) { left: 70%; animation-delay: 1s; }
        .hero-line:nth-child(5) { left: 90%; animation-delay: 3s; }

        @keyframes lineMove {
            0% { transform: translateY(-100%); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(100%); opacity: 0; }
        }

        .hero-content {
            max-width: 1000px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        /* Status Badge - Enhanced */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 22px;
            background: linear-gradient(135deg, rgba(25, 134, 139, 0.2) 0%, rgba(25, 134, 139, 0.05) 100%);
            border: 1px solid rgba(25, 134, 139, 0.5);
            border-radius: 50px;
            margin-bottom: 25px;
            animation: badgeGlow 3s ease-in-out infinite;
            backdrop-filter: blur(10px);
        }

        @keyframes badgeGlow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(25, 134, 139, 0.2), inset 0 0 15px rgba(25, 134, 139, 0.1);
                border-color: rgba(25, 134, 139, 0.5);
            }
            50% { 
                box-shadow: 0 0 35px rgba(25, 134, 139, 0.4), inset 0 0 20px rgba(25, 134, 139, 0.15);
                border-color: rgba(25, 134, 139, 0.8);
            }
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            animation: dotPulse 1.5s ease-in-out infinite;
            box-shadow: 0 0 12px var(--primary);
        }

        @keyframes dotPulse {
            0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 12px var(--primary); }
            50% { transform: scale(1.2); opacity: 0.7; box-shadow: 0 0 18px var(--primary); }
        }

        .status-text {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--primary);
        }

        /* Hero Title - Enhanced */
        .hero-title-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0;
            background: linear-gradient(135deg, var(--white) 0%, rgba(255,255,255,0.9) 50%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: titleShine 5s ease-in-out infinite;
            background-size: 200% 200%;
        }

        @keyframes titleShine {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .hero-title-highlight {
            display: block;
            color: var(--primary);
            -webkit-text-fill-color: var(--primary);
            position: relative;
        }

        .hero-title-highlight::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--secondary), var(--primary), transparent);
            border-radius: 2px;
            animation: underlineGlow 3s ease-in-out infinite;
        }

        @keyframes underlineGlow {
            0%, 100% { width: 150px; opacity: 0.7; }
            50% { width: 220px; opacity: 1; }
        }

        /* Hero Subtitle */
        .hero-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Progress Section - Enhanced */
        .progress-section {
            max-width: 450px;
            margin: 0 auto 40px;
            padding: 22px 30px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .progress-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
        }

        .progress-title i {
            color: var(--primary);
            font-size: 14px;
        }

        .progress-percentage {
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .progress-bar-wrapper {
            position: relative;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--primary));
            background-size: 200% 100%;
            border-radius: 8px;
            width: 75%;
            animation: progressFill 2s ease-out, progressShine 2s ease-in-out infinite;
            position: relative;
        }

        .progress-bar-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: progressGlare 2s ease-in-out infinite;
        }

        @keyframes progressFill {
            from { width: 0; }
        }

        @keyframes progressShine {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes progressGlare {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Stats Row */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 15px;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-value {
            font-size: 34px;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
            margin-bottom: 8px;
        }

        .hero-stat-value span {
            color: var(--primary);
        }

        .hero-stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            animation: scrollBounce 2s ease-in-out infinite;
        }

        .scroll-indicator span {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .scroll-indicator-icon {
            width: 30px;
            height: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            position: relative;
        }

        .scroll-indicator-icon::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 10px;
            background: var(--primary);
            border-radius: 2px;
            animation: scrollDot 2s ease-in-out infinite;
        }

        @keyframes scrollBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        @keyframes scrollDot {
            0%, 100% { top: 8px; opacity: 1; }
            50% { top: 25px; opacity: 0.3; }
        }

        /* Hero Responsive */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 42px;
            }
            
            .hero-stats {
                gap: 35px;
            }
            
            .hero-stat-value {
                font-size: 26px;
            }
        }

        @media (max-width: 992px) {
            .hero {
                padding: 40px 30px 60px;
                min-height: auto;
            }
            
            .hero-title {
                font-size: 36px;
            }
            
            .hero-subtitle {
                font-size: 15px;
            }
            
            .hero-stats {
                flex-wrap: wrap;
                gap: 25px;
            }
            
            .hero-orb-1, .hero-orb-2, .hero-orb-3 {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 30px 20px 50px;
            }
            
            .hero-title {
                font-size: 28px;
            }
            
            .hero-title-highlight::after {
                width: 100px;
            }
            
            .hero-subtitle {
                font-size: 14px;
                margin-bottom: 25px;
            }
            
            .status-badge {
                padding: 8px 16px;
                margin-bottom: 20px;
            }
            
            .status-text {
                font-size: 10px;
                letter-spacing: 2px;
            }
            
            .progress-section {
                padding: 16px 18px;
                max-width: 320px;
            }
            
            .progress-percentage {
                font-size: 18px;
            }
            
            .progress-title {
                font-size: 11px;
            }
            
            .hero-stats {
                gap: 20px;
            }
            
            .hero-stat-value {
                font-size: 22px;
            }
            
            .hero-stat-label {
                font-size: 9px;
            }
            
            .scroll-indicator {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 24px;
            }
            
            .hero-stats {
                flex-direction: row;
                gap: 15px;
            }
            
            .hero-stat-value {
                font-size: 20px;
            }
        }

        /* Vision Mission Expertise Section - Modern Redesign */
        .vme-section {
            padding: 100px 50px;
            background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.2) 100%);
            position: relative;
            overflow: hidden;
        }

        .vme-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .vme-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .vme-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .vme-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(135deg, rgba(25, 134, 139, 0.15) 0%, rgba(25, 134, 139, 0.05) 100%);
            border: 1px solid rgba(25, 134, 139, 0.3);
            border-radius: 50px;
            margin-bottom: 20px;
        }

        .vme-header-badge i {
            color: var(--primary);
            font-size: 14px;
        }

        .vme-header-badge span {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--primary);
        }

        .vme-header h2 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--white) 0%, rgba(255,255,255,0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .vme-header p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.6);
            max-width: 600px;
            margin: 0 auto;
        }

        .vme-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }

        /* Individual Card Styles */
        .vme-card {
            position: relative;
            border-radius: 30px;
            padding: 50px 40px;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            min-height: 420px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .vme-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 30px;
            padding: 2px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.05));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .vme-card:hover {
            transform: translateY(-15px) scale(1.02);
        }

        /* Vision Card - Teal Theme */
        .vme-card.vision {
            background: linear-gradient(145deg, rgba(25, 134, 139, 0.15) 0%, rgba(13, 107, 111, 0.08) 100%);
        }

        .vme-card.vision:hover {
            background: linear-gradient(145deg, rgba(25, 134, 139, 0.25) 0%, rgba(13, 107, 111, 0.15) 100%);
            box-shadow: 0 30px 60px rgba(25, 134, 139, 0.3), 0 0 100px rgba(25, 134, 139, 0.1);
        }

        .vme-card.vision .vme-icon-wrapper {
            background: linear-gradient(135deg, #19868b 0%, #0d6b6f 100%);
            box-shadow: 0 15px 40px rgba(25, 134, 139, 0.4);
        }

        .vme-card.vision .vme-number {
            color: rgba(25, 134, 139, 0.15);
        }

        .vme-card.vision .vme-title::after {
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        /* Mission Card - Red/Orange Theme */
        .vme-card.mission {
            background: linear-gradient(145deg, rgba(225, 39, 62, 0.15) 0%, rgba(180, 30, 50, 0.08) 100%);
        }

        .vme-card.mission:hover {
            background: linear-gradient(145deg, rgba(225, 39, 62, 0.25) 0%, rgba(180, 30, 50, 0.15) 100%);
            box-shadow: 0 30px 60px rgba(225, 39, 62, 0.3), 0 0 100px rgba(225, 39, 62, 0.1);
        }

        .vme-card.mission .vme-icon-wrapper {
            background: linear-gradient(135deg, #e1273e 0%, #b41e32 100%);
            box-shadow: 0 15px 40px rgba(225, 39, 62, 0.4);
        }

        .vme-card.mission .vme-number {
            color: rgba(225, 39, 62, 0.15);
        }

        .vme-card.mission .vme-title::after {
            background: linear-gradient(90deg, transparent, var(--secondary), transparent);
        }

        /* Expertise Card - Gold/Amber Theme */
        .vme-card.expertise {
            background: linear-gradient(145deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.08) 100%);
        }

        .vme-card.expertise:hover {
            background: linear-gradient(145deg, rgba(245, 158, 11, 0.25) 0%, rgba(217, 119, 6, 0.15) 100%);
            box-shadow: 0 30px 60px rgba(245, 158, 11, 0.3), 0 0 100px rgba(245, 158, 11, 0.1);
        }

        .vme-card.expertise .vme-icon-wrapper {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 15px 40px rgba(245, 158, 11, 0.4);
        }

        .vme-card.expertise .vme-number {
            color: rgba(245, 158, 11, 0.15);
        }

        .vme-card.expertise .vme-title::after {
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
        }

        /* Card Elements */
        .vme-number {
            position: absolute;
            top: 20px;
            {{ $isRtl ? 'left' : 'right' }}: 25px;
            font-size: 100px;
            font-weight: 900;
            line-height: 1;
            opacity: 1;
            pointer-events: none;
        }

        .vme-icon-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            transition: all 0.4s ease;
        }

        .vme-card:hover .vme-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .vme-icon-wrapper i {
            font-size: 42px;
            color: var(--white);
        }

        .vme-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--white);
            position: relative;
            padding-bottom: 20px;
        }

        .vme-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            border-radius: 2px;
        }

        .vme-text {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.9;
            flex-grow: 1;
            position: relative;
            z-index: 1;
        }

        .vme-decoration {
            position: absolute;
            bottom: -50px;
            {{ $isRtl ? 'left' : 'right' }}: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
            pointer-events: none;
        }

        .vme-card.vision .vme-decoration {
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
        }

        .vme-card.mission .vme-decoration {
            background: radial-gradient(circle, var(--secondary) 0%, transparent 70%);
        }

        .vme-card.expertise .vme-decoration {
            background: radial-gradient(circle, #f59e0b 0%, transparent 70%);
        }

        /* Floating elements animation */
        .vme-float {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            animation: vmeFloat 6s ease-in-out infinite;
        }

        .vme-card.vision .vme-float {
            background: var(--primary);
        }

        .vme-card.mission .vme-float {
            background: var(--secondary);
        }

        .vme-card.expertise .vme-float {
            background: #f59e0b;
        }

        .vme-float-1 {
            width: 8px;
            height: 8px;
            top: 30%;
            {{ $isRtl ? 'right' : 'left' }}: 15%;
            animation-delay: 0s;
        }

        .vme-float-2 {
            width: 6px;
            height: 6px;
            top: 60%;
            {{ $isRtl ? 'left' : 'right' }}: 20%;
            animation-delay: 2s;
        }

        .vme-float-3 {
            width: 10px;
            height: 10px;
            bottom: 25%;
            {{ $isRtl ? 'right' : 'left' }}: 25%;
            animation-delay: 4s;
        }

        @keyframes vmeFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.2); }
        }

        /* VME Responsive */
        @media (max-width: 1200px) {
            .vme-grid {
                gap: 30px;
            }
            
            .vme-card {
                padding: 40px 30px;
                min-height: 380px;
            }
            
            .vme-icon-wrapper {
                width: 80px;
                height: 80px;
            }
            
            .vme-icon-wrapper i {
                font-size: 34px;
            }
            
            .vme-title {
                font-size: 22px;
            }
            
            .vme-number {
                font-size: 80px;
            }
        }

        @media (max-width: 992px) {
            .vme-section {
                padding: 80px 30px;
            }
            
            .vme-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }
            
            .vme-card {
                min-height: auto;
                padding: 40px 35px;
            }
            
            .vme-header h2 {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .vme-section {
                padding: 60px 20px;
            }
            
            .vme-header {
                margin-bottom: 50px;
            }
            
            .vme-header h2 {
                font-size: 28px;
            }
            
            .vme-header p {
                font-size: 15px;
            }
            
            .vme-card {
                padding: 35px 25px;
                border-radius: 20px;
            }
            
            .vme-icon-wrapper {
                width: 70px;
                height: 70px;
                border-radius: 20px;
            }
            
            .vme-icon-wrapper i {
                font-size: 28px;
            }
            
            .vme-title {
                font-size: 20px;
            }
            
            .vme-text {
                font-size: 14px;
            }
            
            .vme-number {
                font-size: 60px;
                top: 15px;
                {{ $isRtl ? 'left' : 'right' }}: 15px;
            }
        }

        /* About Section */
        .about-section {
            padding: 80px 50px;
            background: rgba(0, 0, 0, 0.3);
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-label {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(25, 134, 139, 0.2);
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.6);
            max-width: 600px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.9;
        }

        .about-features {
            display: grid;
            gap: 25px;
        }

        .feature-item {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            transform: translateX({{ $isRtl ? '-10px' : '10px' }});
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .feature-content h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.7;
        }

        /* Download Profile Button */
        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 15px 30px;
            background: var(--gradient-primary);
            border: none;
            border-radius: 50px;
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(25, 134, 139, 0.3);
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(25, 134, 139, 0.4);
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 50px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s ease;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
        }

        .contact-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }

        .contact-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 10px;
        }

        .contact-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--white);
        }

        .contact-value a {
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-value a:hover {
            color: var(--primary);
        }

        /* Branches Section */
        .branches-section {
            padding: 80px 50px;
            background: rgba(0, 0, 0, 0.3);
        }

        .branches-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .branch-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
            transition: all 0.4s ease;
        }

        .branch-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
        }

        .branch-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .branch-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .branch-name {
            font-size: 20px;
            font-weight: 700;
        }

        .branch-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .branch-info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .branch-info-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            background: rgba(25, 134, 139, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 14px;
        }

        .branch-info-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        .branch-info-text a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .branch-info-text a:hover {
            color: var(--primary);
        }

        /* Social Links */
        .social-section {
            padding: 60px 50px;
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .social-link {
            width: 55px;
            height: 55px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 22px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        /* Location Section */
        .location-section {
            padding: 80px 50px;
            background: rgba(0, 0, 0, 0.3);
        }

        .location-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .location-content {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 50px;
            align-items: stretch;
        }

        .location-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .location-info h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--white);
        }

        .location-info p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .location-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .location-detail-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .location-detail-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--white);
        }

        .location-detail-text h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 5px;
        }

        .location-detail-text p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
            line-height: 1.6;
        }

        .location-detail-text a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .location-detail-text a:hover {
            color: var(--primary);
        }

        .location-map {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 350px;
        }

        .location-map iframe {
            width: 100%;
            height: 100%;
            min-height: 350px;
            border: none;
            filter: grayscale(30%) contrast(1.1);
            transition: filter 0.3s ease;
        }

        .location-map:hover iframe {
            filter: grayscale(0%) contrast(1);
        }

        @media (max-width: 992px) {
            .location-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .location-map {
                min-height: 300px;
            }
            
            .location-map iframe {
                min-height: 300px;
            }
        }

        @media (max-width: 768px) {
            .location-section {
                padding: 50px 25px;
            }
            
            .location-info h3 {
                font-size: 26px;
            }
            
            .location-map {
                min-height: 250px;
            }
            
            .location-map iframe {
                min-height: 250px;
            }
        }

        /* Footer */
        .footer {
            padding: 30px 50px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .info-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .contact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .hero-title {
                font-size: 42px;
            }
            
            .about-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .section-title {
                font-size: 32px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px 25px;
                flex-direction: column;
                gap: 20px;
            }
            
            .hero {
                padding: 30px 25px;
            }
            
            .hero-title {
                font-size: 32px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
            
            .info-cards {
                grid-template-columns: 1fr;
            }
            
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .branches-grid {
                grid-template-columns: 1fr;
            }
            
            .about-section,
            .contact-section,
            .branches-section,
            .social-section {
                padding: 50px 25px;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .geo-shape-1,
            .geo-shape-2 {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 26px;
            }
            
            .status-badge {
                padding: 10px 18px;
            }
            
            .status-text {
                font-size: 12px;
                letter-spacing: 1px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="geo-shape geo-shape-1"></div>
    <div class="geo-shape geo-shape-2"></div>

    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <img src="{{ asset('pic/logo.png') }}" alt="Smart Vision">
            </div>
            <div class="lang-switch">
                @php
                    try {
                        $enUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en');
                        $arUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('ar');
                    } catch (\Exception $e) {
                        $enUrl = url('/en');
                        $arUrl = url('/ar');
                    }
                @endphp
                <a href="{{ $enUrl }}" class="lang-btn {{ $locale == 'en' ? 'active' : '' }}">English</a>
                <a href="{{ $arUrl }}" class="lang-btn {{ $locale == 'ar' ? 'active' : '' }}">العربية</a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <!-- Background Effects -->
            <div class="hero-bg-gradient"></div>
            <div class="hero-orb hero-orb-1"></div>
            <div class="hero-orb hero-orb-2"></div>
            <div class="hero-orb hero-orb-3"></div>
            
            <div class="hero-lines">
                <div class="hero-line"></div>
                <div class="hero-line"></div>
                <div class="hero-line"></div>
                <div class="hero-line"></div>
                <div class="hero-line"></div>
            </div>

            <div class="hero-content">
                <div class="status-badge">
                    <span class="status-dot"></span>
                    <span class="status-text">{{ $isRtl ? 'قيد الإنشاء' : 'Under Construction' }}</span>
                </div>
                
                <div class="hero-title-wrapper">
                    <h1 class="hero-title">
                        {{ $isRtl ? 'نحن نبني' : 'We\'re Building' }}
                        <span class="hero-title-highlight">{{ $isRtl ? 'شيئاً مذهلاً' : 'Something Amazing' }}</span>
                    </h1>
                </div>
                
                <p class="hero-subtitle">
                    {{ $isRtl ? 'موقعنا الإلكتروني قيد التطوير حالياً. نعمل بجد لنقدم لكم تجربة أفضل وأكثر تميزاً. يرجى العودة قريباً!' : 'Our website is currently under development. We\'re working hard to bring you a better and more exceptional experience. Please check back soon!' }}
                </p>
                
                <!-- Enhanced Progress Section -->
                <div class="progress-section">
                    <div class="progress-header">
                        <div class="progress-title">
                            <i class="fas fa-rocket"></i>
                            <span>{{ $isRtl ? 'تقدم التطوير' : 'Development Progress' }}</span>
                        </div>
                        <div class="progress-percentage">75%</div>
                    </div>
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill"></div>
                    </div>
                    <div class="progress-info">
                        <span>{{ $isRtl ? 'التصميم والتطوير' : 'Design & Development' }}</span>
                        <span>{{ $isRtl ? 'قريباً جداً' : 'Coming Very Soon' }}</span>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">3000<span>+</span></div>
                        <div class="hero-stat-label">{{ $isRtl ? 'مشاريع ناجحة' : 'Successful Projects' }}</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">13<span>+</span></div>
                        <div class="hero-stat-label">{{ $isRtl ? 'سنوات من الخبرة' : 'Years of Expertise' }}</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">250<span>+</span></div>
                        <div class="hero-stat-label">{{ $isRtl ? 'محترف متخصص' : 'Dedicated Professionals' }}</div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Vision, Mission & Expertise Section -->
        <section class="vme-section">
            <div class="vme-container">
                <div class="vme-header">
                    <div class="vme-header-badge">
                        <i class="fas fa-star"></i>
                        <span>{{ $isRtl ? 'ما يميزنا' : 'What Defines Us' }}</span>
                    </div>
                    <h2>{{ $isRtl ? 'رؤيتنا ومهمتنا وخبرتنا' : 'Our Vision, Mission & Expertise' }}</h2>
                    <p>{{ $isRtl ? 'القيم الأساسية التي توجه عملنا وتشكل مستقبلنا' : 'The core values that guide our work and shape our future' }}</p>
                </div>

                <div class="vme-grid">
                    <!-- Vision Card -->
                    <div class="vme-card vision">
                        <span class="vme-number">01</span>
                        <div class="vme-float vme-float-1"></div>
                        <div class="vme-float vme-float-2"></div>
                        <div class="vme-float vme-float-3"></div>
                        <div class="vme-decoration"></div>
                        
                        <div class="vme-icon-wrapper">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="vme-title">{{ $isRtl ? 'رؤيتنا' : 'Our Vision' }}</h3>
                        <p class="vme-text">
                            @if($aboutInfo && ($isRtl ? $aboutInfo->vision_arabic : $aboutInfo->vision_english))
                                {{ Str::limit(strip_tags($isRtl ? $aboutInfo->vision_arabic : $aboutInfo->vision_english), 200) }}
                            @else
                                {{ $isRtl ? 'أن نكون الشركة الاستشارية الهندسية الرائدة والموثوقة، نقدم حلولاً مبتكرة وعالية القيمة تشكل مستقبل المشاريع التجارية والكبيرة للشركات والأفراد.' : 'Be the leading, trusted engineering consultancy, delivering innovative, high-value solutions that shape the future of commercial and large-scale projects for businesses and individuals.' }}
                            @endif
                        </p>
                    </div>

                    <!-- Mission Card -->
                    <div class="vme-card mission">
                        <span class="vme-number">02</span>
                        <div class="vme-float vme-float-1"></div>
                        <div class="vme-float vme-float-2"></div>
                        <div class="vme-float vme-float-3"></div>
                        <div class="vme-decoration"></div>
                        
                        <div class="vme-icon-wrapper">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="vme-title">{{ $isRtl ? 'مهمتنا' : 'Our Mission' }}</h3>
                        <p class="vme-text">
                            @if($aboutInfo && ($isRtl ? $aboutInfo->mission_arabic : $aboutInfo->mission_english))
                                {{ Str::limit(strip_tags($isRtl ? $aboutInfo->mission_arabic : $aboutInfo->mission_english), 200) }}
                            @else
                                {{ $isRtl ? 'تقديم حلول هندسية مبتكرة تعتمد على التكنولوجيا تمكّن العملاء، وتعزز الاستدامة، وتخلق قيمة دائمة من خلال التوجيه الخبير وإدارة المشاريع الفعالة.' : 'Deliver innovative, technology-driven engineering solutions that empower clients, foster sustainability, and create lasting value through expert guidance and efficient project management.' }}
                            @endif
                        </p>
                    </div>

                    <!-- Expertise Card -->
                    <div class="vme-card expertise">
                        <span class="vme-number">03</span>
                        <div class="vme-float vme-float-1"></div>
                        <div class="vme-float vme-float-2"></div>
                        <div class="vme-float vme-float-3"></div>
                        <div class="vme-decoration"></div>
                        
                        <div class="vme-icon-wrapper">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3 class="vme-title">{{ $isRtl ? 'خبرتنا' : 'Our Expertise' }}</h3>
                        <p class="vme-text">
                            {{ $isRtl ? 'متخصصون في تقديم حلول تصميم مبتكرة تجمع بين التميز المعماري والتطور الداخلي منذ عام 2013. فريقنا المتخصص يعمل معكم من المفهوم إلى الإنجاز.' : 'Specializing in delivering innovative design solutions that combine architectural excellence with interior sophistication since 2013. Our dedicated team works with you from concept to completion.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <div class="section-container">
                <div class="section-header">
                    <span class="section-label">{{ $isRtl ? 'من نحن' : 'About Us' }}</span>
                    <h2 class="section-title">Smart Vision Eng. Consultants LLC</h2>
                    <p class="section-subtitle">
                        {{ $isRtl ? 'شركة هندسية متكاملة تأسست في الشارقة، الإمارات العربية المتحدة، عام 2013' : 'A fully integrated engineering firm, established in Sharjah, UAE, in 2013' }}
                    </p>
                </div>
                
                <div class="about-content">
                    <div class="about-text">
                        @if($aboutInfo && ($isRtl ? $aboutInfo->about_arabic : $aboutInfo->about_english))
                            {!! Str::limit(strip_tags($isRtl ? $aboutInfo->about_arabic : $aboutInfo->about_english), 600) !!}
                        @else
                            {{ $isRtl ? 'سمارت فيجن للاستشارات الهندسية ش.ذ.م.م هي شركة هندسية متكاملة، تأسست في الشارقة، الإمارات العربية المتحدة، في عام 2013. نحن متخصصون في تقديم حلول تصميم مبتكرة تجمع بين التميز المعماري والتطور الداخلي. مهمتنا هي إنشاء مساحات جذابة من الناحية الجمالية وعملية للغاية، مصممة لتلبية احتياجاتك الخاصة. يعمل فريقنا المتخصص من الخبراء معك عن كثب من المفهوم إلى الإنجاز، مما يضمن تصاميم جميلة وعملية.' : 'Smart Vision Eng. Consultants LLC is a fully integrated engineering firm, established in Sharjah, United Arab Emirates, in 2013. We specialize in delivering innovative design solutions that combine architectural excellence with interior sophistication. Our mission is to create spaces that are both aesthetically striking and highly functional, tailored to meet your specific needs. Our dedicated team of experts works closely with you from concept to completion, ensuring designs that are both beautiful and practical.' }}
                        @endif
                        
                        @if($aboutInfo && $aboutInfo->company_profile)
                            <a href="{{ asset('storage/' . $aboutInfo->company_profile) }}" class="download-btn" target="_blank" download>
                                <i class="fas fa-file-pdf"></i>
                                {{ $isRtl ? 'تحميل ملف الشركة' : 'Download Company Profile' }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-drafting-compass"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ $isRtl ? 'التصميم المعماري' : 'Architectural Design' }}</h4>
                                <p>{{ $isRtl ? 'حلول تصميم مبتكرة تجمع بين الجمال والوظيفة' : 'Innovative design solutions combining aesthetics with functionality' }}</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-couch"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ $isRtl ? 'التصميم الداخلي' : 'Interior Design' }}</h4>
                                <p>{{ $isRtl ? 'مساحات داخلية أنيقة ومريحة تعكس ذوقك' : 'Elegant and comfortable interior spaces reflecting your taste' }}</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-hard-hat"></i>
                            </div>
                            <div class="feature-content">
                                <h4>{{ $isRtl ? 'إدارة المشاريع' : 'Project Management' }}</h4>
                                <p>{{ $isRtl ? 'إشراف شامل من المفهوم إلى الإنجاز' : 'Comprehensive oversight from concept to completion' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="section-container">
                <div class="section-header">
                    <span class="section-label">{{ $isRtl ? 'تواصل معنا' : 'Contact Us' }}</span>
                    <h2 class="section-title">{{ $isRtl ? 'نحن هنا لمساعدتك' : 'We\'re Here to Help' }}</h2>
                    <p class="section-subtitle">
                        {{ $isRtl ? 'تواصل معنا لأي استفسارات أو معلومات' : 'Reach out to us for any inquiries or information' }}
                    </p>
                </div>
                
                <div class="contact-grid">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-label">{{ $isRtl ? 'البريد الإلكتروني' : 'Email' }}</div>
                        <div class="contact-value">
                            <a href="mailto:{{ $contactInfo->email ?? 'info@smartvgroup.com' }}">
                                {{ $contactInfo->email ?? 'info@smartvgroup.com' }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-label">{{ $isRtl ? 'الهاتف' : 'Phone' }}</div>
                        <div class="contact-value">
                            <a href="tel:{{ $contactInfo->mobile ?? '+971000000000' }}">
                                {{ $contactInfo->mobile ?? '+971 00 000 0000' }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-label">{{ $isRtl ? 'واتساب' : 'WhatsApp' }}</div>
                        <div class="contact-value">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp ?? '') }}" target="_blank">
                                {{ $contactInfo->whatsapp ?? '+971 00 000 0000' }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-label">{{ $isRtl ? 'الموقع' : 'Location' }}</div>
                        <div class="contact-value">
                            {{ $isRtl ? ($contactInfo->location_text_arabic ?? 'الشارقة، الإمارات') : ($contactInfo->location_text_english ?? 'Sharjah, UAE') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Branches Section -->
        @if($branches && $branches->count() > 0)
        <section class="branches-section">
            <div class="section-container">
                <div class="section-header">
                    <span class="section-label">{{ $isRtl ? 'فروعنا' : 'Our Branches' }}</span>
                    <h2 class="section-title">{{ $isRtl ? 'مواقعنا' : 'Our Locations' }}</h2>
                    <p class="section-subtitle">
                        {{ $isRtl ? 'نحن متواجدون في عدة مواقع لخدمتكم بشكل أفضل' : 'We are present in multiple locations to serve you better' }}
                    </p>
                </div>
                
                <div class="branches-grid">
                    @foreach($branches as $branch)
                    <div class="branch-card">
                        <div class="branch-header">
                            <div class="branch-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="branch-name">{{ $isRtl ? $branch->name_arabic : $branch->name_english }}</h3>
                        </div>
                        
                        <div class="branch-info">
                            @if($branch->location_text_english || $branch->location_text_arabic)
                            <div class="branch-info-item">
                                <div class="branch-info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="branch-info-text">
                                    {{ $isRtl ? $branch->location_text_arabic : $branch->location_text_english }}
                                </div>
                            </div>
                            @endif
                            
                            @if($branch->mobile)
                            <div class="branch-info-item">
                                <div class="branch-info-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="branch-info-text">
                                    <a href="tel:{{ $branch->mobile }}">{{ $branch->mobile }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($branch->email)
                            <div class="branch-info-item">
                                <div class="branch-info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="branch-info-text">
                                    <a href="mailto:{{ $branch->email }}">{{ $branch->email }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($branch->opening_hours)
                            <div class="branch-info-item">
                                <div class="branch-info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="branch-info-text">
                                    {{ $branch->opening_hours }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Location Section -->
        @if($contactInfo && $contactInfo->location_map)
        <section class="location-section">
            <div class="location-container">
                <div class="section-header">
                    <span class="section-label">{{ $isRtl ? 'موقعنا' : 'Our Location' }}</span>
                    <h2 class="section-title">{{ $isRtl ? 'زورونا' : 'Visit Us' }}</h2>
                    <p class="section-subtitle">
                        {{ $isRtl ? 'نرحب بزيارتكم في مقرنا الرئيسي' : 'We welcome you to visit our headquarters' }}
                    </p>
                </div>
                
                <div class="location-content">
                    <div class="location-info">
                        <h3>{{ $isRtl ? 'المقر الرئيسي' : 'Headquarters' }}</h3>
                        <p>{{ $isRtl ? ($contactInfo->location_text_arabic ?? 'الشارقة، الإمارات العربية المتحدة') : ($contactInfo->location_text_english ?? 'Sharjah, United Arab Emirates') }}</p>
                        
                        <div class="location-details">
                            @if($contactInfo->mobile)
                            <div class="location-detail-item">
                                <div class="location-detail-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="location-detail-text">
                                    <h4>{{ $isRtl ? 'اتصل بنا' : 'Call Us' }}</h4>
                                    <p><a href="tel:{{ $contactInfo->mobile }}">{{ $contactInfo->mobile }}</a></p>
                                </div>
                            </div>
                            @endif
                            
                            @if($contactInfo->email)
                            <div class="location-detail-item">
                                <div class="location-detail-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="location-detail-text">
                                    <h4>{{ $isRtl ? 'راسلنا' : 'Email Us' }}</h4>
                                    <p><a href="mailto:{{ $contactInfo->email }}">{{ $contactInfo->email }}</a></p>
                                </div>
                            </div>
                            @endif
                            
                            @if($contactInfo->whatsapp)
                            <div class="location-detail-item">
                                <div class="location-detail-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="location-detail-text">
                                    <h4>{{ $isRtl ? 'واتساب' : 'WhatsApp' }}</h4>
                                    <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp) }}" target="_blank">{{ $contactInfo->whatsapp }}</a></p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="location-map">
                        @php
                            $mapCode = $contactInfo->location_map;
                            // Decode HTML entities if needed
                            if (strpos($mapCode, '&lt;') !== false || strpos($mapCode, '&gt;') !== false) {
                                $mapCode = html_entity_decode($mapCode);
                            }
                            // Check if it's just a URL or full iframe code
                            if (strpos($mapCode, '<iframe') === false && strpos($mapCode, 'google.com/maps') !== false) {
                                // It's just a URL, wrap it in iframe
                                $mapCode = '<iframe src="' . $mapCode . '" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                            }
                        @endphp
                        {!! $mapCode !!}
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Social Section -->
        <section class="social-section">
            <div class="section-container">
                <h3 class="section-title" style="font-size: 28px;">{{ $isRtl ? 'تابعونا' : 'Follow Us' }}</h3>
                <p class="section-subtitle">{{ $isRtl ? 'ابق على اتصال معنا عبر وسائل التواصل الاجتماعي' : 'Stay connected with us on social media' }}</p>
                
                <div class="social-links">
                    @if($contactInfo && $contactInfo->facebook)
                    <a href="{{ $contactInfo->facebook }}" class="social-link" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    
                    @if($contactInfo && $contactInfo->instagram)
                    <a href="{{ $contactInfo->instagram }}" class="social-link" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    
                    @if($contactInfo && $contactInfo->linkedin)
                    <a href="{{ $contactInfo->linkedin }}" class="social-link" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    
                    @if($contactInfo && $contactInfo->twitter)
                    <a href="{{ $contactInfo->twitter }}" class="social-link" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    
                    @if($contactInfo && $contactInfo->pinterest)
                    <a href="{{ $contactInfo->pinterest }}" class="social-link" target="_blank" title="Pinterest">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    @endif
                    
                    @if($contactInfo && $contactInfo->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo->whatsapp) }}" class="social-link" target="_blank" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p class="footer-text">
                &copy; {{ date('Y') }} Smart Vision Eng. Consultants LLC. {{ $isRtl ? 'جميع الحقوق محفوظة.' : 'All Rights Reserved.' }}
            </p>
        </footer>
    </div>

    <script>
        // Add smooth scroll for any internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
