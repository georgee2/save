<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Smart Vision Group</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="{{url('/pic/ficon1.png')}}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Front-end colors from themes.css */
            --primary-color: #19868b;
            --primary-dark: #146a6e;
            --primary-light: #1fa0a6;
            --secondary-color: #e1273d;
            --secondary-dark: #c41f33;
            --dark-color: #172e38;
            --accent-color: #eff6f7;
            --success-color: #28a745;
            --warning-color: #f6b500;
            --orange-color: #ff6935;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #f5f7fa 0%, var(--accent-color) 100%);
        }

        .login-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side - Branding */
        .login-branding {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--dark-color) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .login-branding::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .login-branding::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(225, 39, 61, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .branding-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
        }

        .branding-logo {
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.1);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .branding-logo img {
            max-width: 140px;
            max-height: 140px;
            object-fit: contain;
        }

        .branding-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .branding-content p {
            font-size: 1.1rem;
            opacity: 0.85;
            max-width: 400px;
            line-height: 1.6;
        }

        .branding-features {
            margin-top: 50px;
            display: flex;
            gap: 30px;
        }

        .feature-item {
            text-align: center;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            transition: all 0.3s ease;
        }

        .feature-item:hover .feature-icon {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        .feature-icon i {
            font-size: 1.2rem;
            color: #fff;
        }

        .feature-item span {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Right Side - Login Form */
        .login-form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            background: #fff;
        }

        .login-form-container {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header .mobile-logo {
            display: none;
            width: 80px;
            margin-bottom: 20px;
        }

        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 1rem;
        }

        /* Alert Messages */
        .alert-box {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-box.error {
            background: linear-gradient(135deg, rgba(225, 39, 61, 0.1), rgba(225, 39, 61, 0.05));
            border: 1px solid rgba(225, 39, 61, 0.2);
        }

        .alert-box.success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .alert-box.warning {
            background: linear-gradient(135deg, rgba(246, 181, 0, 0.15), rgba(246, 181, 0, 0.05));
            border: 1px solid rgba(246, 181, 0, 0.3);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .alert-box.error .alert-icon {
            background: var(--secondary-color);
            color: #fff;
        }

        .alert-box.success .alert-icon {
            background: var(--success-color);
            color: #fff;
        }

        .alert-box.warning .alert-icon {
            background: var(--warning-color);
            color: #fff;
        }

        .alert-content h6 {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .alert-box.error .alert-content h6 { color: var(--secondary-color); }
        .alert-box.success .alert-content h6 { color: var(--success-color); }
        .alert-box.warning .alert-content h6 { color: #c9a227; }

        .alert-content p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 1rem;
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 16px 18px 16px 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(25, 134, 139, 0.1);
        }

        .form-control:focus ~ i.input-icon,
        .form-control:not(:placeholder-shown) ~ i.input-icon {
            color: var(--primary-color);
        }

        .form-control.is-invalid {
            border-color: var(--secondary-color);
            background: rgba(225, 39, 61, 0.02);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(225, 39, 61, 0.1);
        }

        .form-control.is-invalid ~ i.input-icon {
            color: var(--secondary-color);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            color: var(--secondary-color);
            font-size: 0.85rem;
            animation: slideIn 0.3s ease;
        }

        .error-message i {
            font-size: 0.9rem;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .remember-me span {
            color: #666;
            font-size: 0.95rem;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 16px 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(25, 134, 139, 0.35);
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(25, 134, 139, 0.45);
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        .btn-login.loading .spinner {
            display: block;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Divider */
        .login-divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            gap: 15px;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        .login-divider span {
            color: #adb5bd;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
        }

        .login-footer p {
            color: #666;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--secondary-color);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .login-branding {
                display: none;
            }

            .login-form-section {
                padding: 40px 30px;
            }

            .login-header .mobile-logo {
                display: block;
                margin: 0 auto 20px;
            }
        }

        @media (max-width: 576px) {
            .login-form-section {
                padding: 30px 20px;
            }

            .login-form-container {
                max-width: 100%;
            }

            .form-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        #preloader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid #e9ecef;
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* Accent decoration */
        .accent-line {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
            margin: 15px auto 0;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-branding">
            <div class="branding-content">
                <div class="branding-logo">
                    <img src="{{ asset('/pic/logos/logoarfooter.png') }}" alt="Smart Vision Group">
                </div>
                <h1>Smart Vision Group</h1>
                <p>Access your dashboard to manage content, users, and system settings with ease.</p>
                
                <div class="branding-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa fa-shield"></i>
                        </div>
                        <span>Secure Access</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa fa-dashboard"></i>
                        </div>
                        <span>Easy Management</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <span>24/7 Available</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form-section">
            <div class="login-form-container">
                <div class="login-header">
                    <img src="{{ asset('/pic/logo.png') }}" alt="Logo" class="mobile-logo">
                    <h2>Welcome Back!</h2>
                    <p>Please sign in to access your dashboard</p>
                    <div class="accent-line"></div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert-box success">
                        <div class="alert-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="alert-content">
                            <h6>Success</h6>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert-box error">
                        <div class="alert-icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <h6>Login Failed</h6>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('checkuser') }}" method="POST" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Enter your email"
                                   autocomplete="email"
                                   required>
                            <i class="fa fa-envelope input-icon"></i>
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   required>
                            <i class="fa fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fa fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-text">
                            <i class="fa fa-sign-in"></i> Sign In
                        </span>
                        <div class="spinner"></div>
                    </button>
                </form>

                <div class="login-footer">
                    <p>&copy; {{ date('Y') }} Content Management System.<br>Developed by <a href="#">Smart Vision Group</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide preloader when page loads
        window.addEventListener('load', function() {
            document.getElementById('preloader').classList.add('hidden');
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            // Basic client-side validation
            let hasError = false;

            if (!email) {
                showFieldError('email', 'Please enter your email address');
                hasError = true;
            } else if (!isValidEmail(email)) {
                showFieldError('email', 'Please enter a valid email address');
                hasError = true;
            }

            if (!password) {
                showFieldError('password', 'Please enter your password');
                hasError = true;
            } else if (password.length < 6) {
                showFieldError('password', 'Password must be at least 6 characters');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                return;
            }

            // Show loading state
            btn.classList.add('loading');
            btn.disabled = true;
        });

        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const wrapper = field.closest('.form-group');
            
            // Remove existing error
            const existingError = wrapper.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }

            // Add error class
            field.classList.add('is-invalid');

            // Create error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<i class="fa fa-exclamation-circle"></i><span>${message}</span>`;
            
            wrapper.appendChild(errorDiv);
        }

        // Remove error on input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const wrapper = this.closest('.form-group');
                const error = wrapper.querySelector('.error-message');
                if (error) {
                    error.remove();
                }
            });
        });
    </script>
</body>

</html>
