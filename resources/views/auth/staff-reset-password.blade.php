<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('lang.staff_reset_page_title') }} - Smart Vision Group</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/sweetalert2.min.css') }}?v=11">
    <link rel="shortcut icon" href="{{ url('/pic/ficon1.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #19868b;
            --primary-dark: #146a6e;
            --secondary-color: #e1273d;
            --dark-color: #172e38;
            --accent-color: #eff6f7;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--dark-color) 100%);
        }

        .reset-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            padding: 40px 36px;
        }

        .reset-header { text-align: center; margin-bottom: 28px; }
        .reset-header img { max-width: 170px; height: auto; margin-bottom: 18px; }
        .reset-header h2 { font-size: 1.5rem; font-weight: 700; color: var(--dark-color); }
        .reset-header p { color: #7a7a7a; font-size: 0.92rem; margin-top: 6px; }
        .accent-line { width: 56px; height: 4px; background: var(--secondary-color); border-radius: 4px; margin: 14px auto 0; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; font-size: 0.88rem; color: var(--dark-color); margin-bottom: 8px; }

        .input-wrapper { position: relative; }
        .input-wrapper .form-control {
            width: 100%;
            padding: 12px 44px 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .input-wrapper .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(25, 134, 139, 0.12); }
        .input-wrapper .form-control[readonly] { background: #f5f7fa; color: #6b7280; }

        .password-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 12px;
            background: none;
            border: none;
            color: #9aa5b1;
            cursor: pointer;
            font-size: 1rem;
        }

        .form-hint { display: block; font-size: 0.78rem; color: #8a94a6; margin-top: 6px; }

        .btn-reset {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 6px;
        }
        .btn-reset:hover { opacity: 0.92; }

        .alert-box {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            background: #fdecee;
            border: 1px solid #f5c2c7;
            color: #a12633;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 0.88rem;
        }

        .reset-footer { text-align: center; margin-top: 22px; }
        .reset-footer a { color: var(--primary-color); font-weight: 600; text-decoration: none; }
    </style>
</head>

<body>
    <div class="reset-card">
        <div class="reset-header">
            <img src="{{ asset('/pic/logo.png') }}" alt="Logo">
            <h2>{{ __('lang.staff_reset_page_title') }}</h2>
            <p>{{ __('lang.staff_reset_page_subtitle') }}</p>
            <div class="accent-line"></div>
        </div>

        @if($errors->any())
            <div class="alert-box">
                <i class="fa fa-exclamation-triangle" style="margin-top:2px;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('staff.password.update') }}" method="POST" id="staffResetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">{{ __('lang.staff_profile_email') }}</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" class="form-control" required readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="password">{{ __('lang.account_password') }}</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" required minlength="8" autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="toggleField('password', this)"><i class="fa fa-eye"></i></button>
                </div>
                <small class="form-hint">{{ __('lang.account_password_hint') }}</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('lang.account_confirm_password') }}</label>
                <div class="input-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8" autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="toggleField('password_confirmation', this)"><i class="fa fa-eye"></i></button>
                </div>
            </div>

            <button type="submit" class="btn-reset">
                <i class="fa fa-check-circle"></i> {{ __('lang.staff_reset_submit') }}
            </button>
        </form>

        <div class="reset-footer">
            <a href="{{ route('login') }}"><i class="fa fa-angle-left"></i> {{ __('lang.account_back_to_login') }}</a>
        </div>
    </div>

    <script src="{{ asset('/assets/js/sweetalert2.min.js') }}?v=11"></script>
    <script>
        function toggleField(id, btn) {
            var input = document.getElementById(id);
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('staffResetForm').addEventListener('submit', function (e) {
            var pw = document.getElementById('password');
            var confirm = document.getElementById('password_confirmation');
            if (pw.value !== confirm.value) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: @json(app()->getLocale() === 'ar' ? 'خطأ' : 'Error'),
                        text: @json(__('lang.account_confirm_password')),
                        confirmButtonColor: '#e1273d'
                    });
                }
            }
        });
    </script>
</body>

</html>
