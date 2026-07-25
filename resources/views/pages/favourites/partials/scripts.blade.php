{{-- Shared favourites interactions: ref-id copy, tabs, remove, clear-all, share, send-email.
     Kept as a Blade partial so the locale-prefixed /favourites/* URLs interpolate.
     Used by the guest favourites page and the customer account favourites page. --}}
<script>
function copyRefId() {
    var el = document.getElementById('favRefId');
    var id = el ? el.getAttribute('data-id') : '';
    var btn = el ? el.querySelector('.fav-ref-copy') : null;
    if (!id) return;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(id).then(function() { showRefCopied(btn); });
    } else {
        var input = document.createElement('input');
        input.value = id;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        showRefCopied(btn);
    }
}

function showRefCopied(btn) {
    if (!btn) return;
    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fal fa-check"></i>';
    btn.classList.add('copied');
    setTimeout(function() { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    var tabs = document.querySelectorAll('.fav-tab');
    var sections = document.querySelectorAll('.fav-section');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            var target = tab.getAttribute('data-target');

            sections.forEach(function(section) {
                if (target === 'all') {
                    section.style.display = '';
                } else {
                    section.style.display = section.getAttribute('data-section') === target ? '' : 'none';
                }
            });
        });
    });

    // Remove single item
    document.querySelectorAll('.fav-remove-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var favId = btn.getAttribute('data-id');
            var item = btn.closest('.fav-item');
            var csrfEl = document.querySelector('meta[name="csrf-token"]');
            var csrf = csrfEl ? csrfEl.getAttribute('content') : '';

            var xhr = new XMLHttpRequest();
            xhr.open('DELETE', '/{{ app()->getLocale() }}/favourites/' + favId, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    item.style.transition = 'all 0.3s ease';
                    setTimeout(function() {
                        item.remove();
                        checkEmpty();
                    }, 300);
                    try {
                        var data = JSON.parse(xhr.responseText);
                        var badges = document.querySelectorAll('.favourite-badge');
                        badges.forEach(function(b) {
                            b.textContent = data.count;
                            b.style.display = data.count > 0 ? '' : 'none';
                        });
                    } catch(e) {}
                }
            };
            xhr.send();
        });
    });

    // Clear all
    var clearBtn = document.getElementById('clearAllFavourites');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (typeof Swal !== 'undefined') {
                var isAr = document.documentElement.getAttribute('lang') === 'ar';
                Swal.fire({
                    title: isAr ? 'هل أنت متأكد؟' : 'Are you sure?',
                    text: isAr ? 'سيتم حذف جميع المفضلات' : 'All favourites will be removed',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e1273d',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isAr ? 'نعم، احذف الكل' : 'Yes, clear all',
                    cancelButtonText: isAr ? 'إلغاء' : 'Cancel',
                }).then(function(result) {
                    if (result.isConfirmed) { doClearAll(); }
                });
            } else {
                if (confirm('Clear all favourites?')) { doClearAll(); }
            }
        });
    }

    function doClearAll() {
        var csrfEl = document.querySelector('meta[name="csrf-token"]');
        var csrf = csrfEl ? csrfEl.getAttribute('content') : '';
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/{{ app()->getLocale() }}/favourites/clear/all', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            }
        };
        xhr.send();
    }

    function checkEmpty() {
        var items = document.querySelectorAll('.fav-item');
        if (items.length === 0) {
            window.location.reload();
        }
    }

    // Share via WhatsApp
    document.querySelectorAll('.fav-share-whatsapp').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = btn.getAttribute('data-url');
            var isAr = document.documentElement.getAttribute('lang') === 'ar';
            var text = isAr
                ? 'شاهد مفضلاتي على سمارت فيجن: ' + url
                : 'Check out my favourites on Smart Vision: ' + url;
            window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
        });
    });

    // Copy link
    document.querySelectorAll('.fav-share-link').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = btn.getAttribute('data-url');
            var isAr = document.documentElement.getAttribute('lang') === 'ar';

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showCopied(btn, isAr);
                });
            } else {
                var input = document.createElement('input');
                input.value = url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                showCopied(btn, isAr);
            }
        });
    });

    function showCopied(btn, isAr) {
        var originalHtml = btn.innerHTML;
        btn.classList.add('copied');
        btn.innerHTML = '<i class="fal fa-check"></i> ' + (isAr ? 'تم النسخ!' : 'Copied!');
        setTimeout(function() {
            btn.classList.remove('copied');
            btn.innerHTML = originalHtml;
        }, 2500);
    }

    // Email modal: close on overlay click
    var emailModal = document.getElementById('favEmailModal');
    if (emailModal) {
        emailModal.addEventListener('click', function(e) {
            if (e.target === emailModal) emailModal.style.display = 'none';
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && emailModal.style.display === 'flex') {
                emailModal.style.display = 'none';
            }
        });
    }

    // Send email
    var sendBtn = document.getElementById('favEmailSendBtn');
    if (sendBtn) {
        sendBtn.addEventListener('click', function() {
            var emailInput = document.getElementById('favEmailInput');
            var nameInput = document.getElementById('favNameInput');
            var email = emailInput.value.trim();
            var name = nameInput.value.trim();
            var isAr = document.documentElement.getAttribute('lang') === 'ar';

            if (!email || !emailInput.checkValidity()) {
                emailInput.focus();
                emailInput.style.borderColor = '#e1273d';
                return;
            }
            emailInput.style.borderColor = '';

            var originalHtml = sendBtn.innerHTML;
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fal fa-spinner fa-spin"></i> ' + (isAr ? 'جاري الإرسال...' : 'Sending...');

            var csrfEl = document.querySelector('meta[name="csrf-token"]');
            var csrf = csrfEl ? csrfEl.getAttribute('content') : '';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/{{ app()->getLocale() }}/favourites/send-email', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
            xhr.onload = function() {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalHtml;

                if (xhr.status === 200) {
                    document.getElementById('favEmailModal').style.display = 'none';
                    emailInput.value = '';
                    nameInput.value = '';

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: isAr ? 'تم الإرسال بنجاح!' : 'Email Sent!',
                            text: isAr ? 'تم إرسال المفضلة إلى بريدك الإلكتروني.' : 'Your favourites have been sent to your email.',
                            confirmButtonColor: '#19868b',
                            confirmButtonText: isAr ? 'حسناً' : 'OK',
                        });
                    } else {
                        alert(isAr ? 'تم إرسال المفضلة إلى بريدك الإلكتروني.' : 'Your favourites have been sent to your email.');
                    }
                } else {
                    // Distinguish the rate limit from a genuine failure, and surface the
                    // server's own message (e.g. "No favourites to send") when it sends one.
                    var isThrottled = xhr.status === 429;
                    var serverMessage = '';
                    try {
                        serverMessage = (JSON.parse(xhr.responseText) || {}).message || '';
                    } catch (e) {}

                    var failTitle = isThrottled
                        ? (isAr ? 'طلبات كثيرة جداً' : 'Too Many Requests')
                        : (isAr ? 'فشل الإرسال' : 'Failed to Send');

                    var failText = isThrottled
                        ? (isAr ? 'لقد أرسلت عدة رسائل مؤخراً. يرجى المحاولة بعد قليل.' : 'You have sent several emails recently. Please try again later.')
                        : (serverMessage || (isAr ? 'حدث خطأ أثناء إرسال البريد الإلكتروني. حاول مرة أخرى.' : 'Something went wrong while sending the email. Please try again.'));

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: isThrottled ? 'warning' : 'error',
                            title: failTitle,
                            text: failText,
                            confirmButtonColor: '#e1273d',
                            confirmButtonText: isAr ? 'حسناً' : 'OK',
                        });
                    } else {
                        alert(failText);
                    }
                }
            };
            xhr.onerror = function() {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalHtml;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: isAr ? 'خطأ في الاتصال' : 'Connection Error',
                        text: isAr ? 'تعذر الاتصال بالخادم. تحقق من اتصالك بالإنترنت.' : 'Could not connect to the server. Please check your connection.',
                        confirmButtonColor: '#e1273d',
                        confirmButtonText: isAr ? 'حسناً' : 'OK',
                    });
                } else {
                    alert(isAr ? 'خطأ في الاتصال' : 'Connection error. Please try again.');
                }
            };
            xhr.send(JSON.stringify({ email: email, name: name }));
        });
    }
});
</script>
