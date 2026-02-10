<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('lang.page_not_found') }} - {{ config('app.name', 'Smart Vision') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: {{ app()->getLocale() == 'ar' ? "'Tajawal'" : "'Outfit'" }}, sans-serif;
            background: linear-gradient(135deg, #0a1628 0%, #1a2d4a 50%, #0d1f35 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            overflow: hidden;
            position: relative;
        }
        
        /* Animated background elements */
        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .bg-shapes .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        
        .bg-shapes .shape:nth-child(1) {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #c9a227, #d4af37);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .bg-shapes .shape:nth-child(2) {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #c9a227, #d4af37);
            bottom: -50px;
            left: -50px;
            animation-delay: -5s;
        }
        
        .bg-shapes .shape:nth-child(3) {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #c9a227, #d4af37);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        .container {
            text-align: center;
            z-index: 1;
            padding: 40px 20px;
            max-width: 600px;
        }
        
        .error-code {
            font-size: 180px;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #c9a227 0%, #d4af37 50%, #f0d060 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            margin-bottom: 20px;
            animation: pulse 2s infinite ease-in-out;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.98); }
        }
        
        .error-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .error-message {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 40px;
            background: linear-gradient(135deg, #c9a227 0%, #d4af37 100%);
            color: #0a1628;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3);
        }
        
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(201, 162, 39, 0.4);
            background: linear-gradient(135deg, #d4af37 0%, #f0d060 100%);
        }
        
        .btn-home svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }
        
        .btn-home:hover svg {
            transform: translateX({{ app()->getLocale() == 'ar' ? '5px' : '-5px' }});
        }
        
        .logo {
            margin-bottom: 30px;
        }
        
        .logo img {
            max-width: 200px;
            height: auto;
        }
        
        /* Decorative lines */
        .decorative-line {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #c9a227, #d4af37);
            margin: 0 auto 30px;
            border-radius: 2px;
        }
        
        @media (max-width: 768px) {
            .error-code {
                font-size: 120px;
            }
            
            .error-title {
                font-size: 24px;
            }
            
            .error-message {
                font-size: 16px;
            }
            
            .btn-home {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 480px) {
            .error-code {
                font-size: 100px;
            }
            
            .error-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            @php
                $aboutInfo = \App\Models\AboutInformation::first();
                $logo = $aboutInfo && $aboutInfo->logo ? asset('storage/' . $aboutInfo->logo) : asset('assets/images/logo-white.png');
            @endphp
            <img src="{{ $logo }}" alt="{{ config('app.name', 'Smart Vision') }}">
        </div>
        
        <!-- Decorative Line -->
        <div class="decorative-line"></div>
        
        <!-- Error Code -->
        <div class="error-code">404</div>
        
        <!-- Error Title -->
        <h1 class="error-title">{{ __('lang.page_not_found') }}</h1>
        
        <!-- Error Message -->
        <p class="error-message">{{ __('lang.page_not_found_message') }}</p>
        
        <!-- Back to Home Button -->
        <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="btn-home">
            @if(app()->getLocale() == 'ar')
                {{ __('lang.back_to_home') }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('lang.back_to_home') }}
            @endif
        </a>
    </div>
</body>
</html>
