<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('lang.under_construction') }}</title>
    <link rel="icon" href="{{ asset('pic/favicon.ico') }}" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4c4c4c 0%, #000000 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: move 25s infinite linear;
            bottom: -150px;
        }

        .bg-animation span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .bg-animation span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .bg-animation span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-animation span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-animation span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .bg-animation span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .bg-animation span:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .bg-animation span:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        .container {
            max-width: 800px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-top: 5px solid #e64c29;
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            margin-bottom: 30px;
            animation: bounce 2s infinite;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .icon {
            font-size: 80px;
            margin-bottom: 30px;
            animation: rotate 3s linear infinite;
            color: #e64c29;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        h1 {
            font-size: 48px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
            line-height: 1.2;
        }

        p {
            font-size: 20px;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 2px solid #e64c29;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e64c29;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            color: #ff7043;
            transform: translateY(-3px);
        }

        .contact-item i {
            font-size: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 40px 30px;
            }

            h1 {
                font-size: 32px;
            }

            p {
                font-size: 16px;
            }

            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('pic/logosvg.svg') }}" alt="Logo">
        </div>

        <!-- Icon -->
        <div class="icon">
            <i class="fas fa-cog"></i>
        </div>

        <!-- Content -->
        <h1>{{ __('lang.under_construction_title') }}</h1>
        <p>{{ __('lang.under_construction_message') }}</p>

        <!-- Contact Info -->
        <div class="contact-info">
            <a href="mailto:info@smartvgroup.com" class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>info@smartvgroup.com</span>
            </a>
            <a href="tel:+1234567890" class="contact-item">
                <i class="fas fa-phone"></i>
                <span>+123 456 7890</span>
            </a>
        </div>
    </div>
</body>
</html>

