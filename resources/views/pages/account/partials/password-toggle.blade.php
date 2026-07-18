{{-- Show/hide password toggle. Buttons: <button class="pw-toggle" data-target="INPUT_ID"><i class="fa fa-eye"></i></button> --}}
<script>
(function () {
    document.querySelectorAll('.pw-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) { return; }
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                btn.setAttribute('aria-label', 'Hide password');
                if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            } else {
                input.type = 'password';
                btn.setAttribute('aria-label', 'Show password');
                if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            }
        });
    });
})();
</script>
