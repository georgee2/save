{{-- Shared SweetAlert2 feedback for the customer portal.
     Swal is already loaded globally in layouts.master. Include this inside @section('js'). --}}
@php
    $accErrorsHtml = '';
    if ($errors->any()) {
        $accErrorsHtml = '<ul style="text-align:left;padding-left:20px;list-style:disc;margin:0;">';
        foreach ($errors->all() as $accError) {
            $accErrorsHtml .= '<li>' . e($accError) . '</li>';
        }
        $accErrorsHtml .= '</ul>';
    }
@endphp
<script>
(function () {
    function runAccountAlerts() {
    if (typeof Swal === 'undefined') { return; }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: @json(__('lang.success')),
            text: @json(session('success')),
            confirmButtonColor: '#19868b',
            timer: 5000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: @json(__('lang.error')),
            text: @json(session('error')),
            confirmButtonColor: '#e1273d'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: @json(__('lang.error')),
            html: @json($accErrorsHtml),
            confirmButtonColor: '#e1273d'
        });
    @endif
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runAccountAlerts);
    } else {
        runAccountAlerts();
    }
})();

// Prevent double submits (which would send duplicate emails): lock the submit
// button once a form is submitted. Deferred so the current submit still proceeds.
(function () {
    function guardForms() {
        var forms = document.querySelectorAll('form.account-form');
        Array.prototype.forEach.call(forms, function (form) {
            form.addEventListener('submit', function () {
                var btn = form.querySelector('button[type="submit"]');
                if (!btn || btn.dataset.locking) { return; }
                btn.dataset.locking = '1';
                setTimeout(function () {
                    btn.disabled = true;
                    btn.style.opacity = '0.7';
                    btn.style.cursor = 'not-allowed';
                }, 0);
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', guardForms);
    } else {
        guardForms();
    }
})();
</script>
