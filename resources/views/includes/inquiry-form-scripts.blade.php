{{-- AJAX submit + reCAPTCHA for the offer/project inquiry forms.
     Include once per page inside @section('js'), passing $inquiryFormSelector and
     $inquiryRecaptchaAction. Mirrors the home inline form in home/contactfaq.blade.php. --}}
@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    var recaptchaSiteKey = '{{ config("services.recaptcha.site_key") }}';
    var isAr = document.documentElement.getAttribute('lang') === 'ar';
    var forms = document.querySelectorAll('{{ $inquiryFormSelector }}');

    function notify(icon, title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: icon === 'success' ? '#19868b' : '#e1273d',
                confirmButtonText: isAr ? 'حسناً' : 'OK',
            });
        } else {
            alert(text);
        }
    }

    function send(form, button, originalHtml) {
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
        .then(function (response) {
            return response.json().then(function (data) {
                return { status: response.status, data: data };
            });
        })
        .then(function (result) {
            button.disabled = false;
            button.innerHTML = originalHtml;

            if (result.status === 200 && result.data.success) {
                form.reset();
                notify('success', isAr ? 'تم الإرسال!' : 'Sent!', result.data.message);
                return;
            }

            // Surface the server's own message where there is one: it distinguishes a
            // rate limit or a stale page from a generic failure.
            var message = result.data.message
                || (result.status === 429
                    ? (isAr ? 'طلبات كثيرة. يرجى المحاولة لاحقاً.' : 'Too many requests. Please try again shortly.')
                    : (isAr ? 'تعذر إرسال طلبك. حاول مرة أخرى.' : 'We could not send your request. Please try again.'));

            notify(result.status === 429 ? 'warning' : 'error', isAr ? 'فشل الإرسال' : 'Not sent', message);
        })
        .catch(function () {
            button.disabled = false;
            button.innerHTML = originalHtml;
            notify('error', isAr ? 'فشل الإرسال' : 'Not sent',
                isAr ? 'تحقق من اتصالك وحاول مرة أخرى.' : 'Check your connection and try again.');
        });
    }

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var button = form.querySelector('button[type="submit"]');
            var originalHtml = button ? button.innerHTML : '';

            if (button) {
                button.disabled = true;
                button.innerHTML = isAr ? 'جارٍ الإرسال...' : 'Sending...';
            }

            if (recaptchaSiteKey && typeof grecaptcha !== 'undefined') {
                grecaptcha.ready(function () {
                    grecaptcha.execute(recaptchaSiteKey, { action: '{{ $inquiryRecaptchaAction }}' })
                        .then(function (token) {
                            var field = form.querySelector('input[name="g-recaptcha-response"]');
                            if (field) { field.value = token; }
                            send(form, button, originalHtml);
                        });
                });
            } else {
                // No key configured, or the script was blocked. The server treats a missing
                // token as a failure only when reCAPTCHA is actually enabled.
                send(form, button, originalHtml);
            }
        });
    });
});
</script>
