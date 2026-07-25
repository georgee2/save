(function() {
    'use strict';

    var CACHE_KEY = 'fav_cache';
    var CACHE_TTL = 300000; // 5 minutes

    function getUrls() {
        var c = document.querySelector('meta[name="favourites-count-url"]');
        var t = document.querySelector('meta[name="favourites-toggle-url"]');
        return {
            count: c ? c.getAttribute('content') : '/favourites/count',
            toggle: t ? t.getAttribute('content') : '/favourites/toggle'
        };
    }

    function getCsrf() {
        var el = document.querySelector('meta[name="csrf-token"]');
        return el ? el.getAttribute('content') : '';
    }

    function getCache() {
        try {
            var raw = sessionStorage.getItem(CACHE_KEY);
            if (!raw) return null;
            var d = JSON.parse(raw);
            if (Date.now() - d.ts > CACHE_TTL) {
                sessionStorage.removeItem(CACHE_KEY);
                return null;
            }
            return d;
        } catch(e) { return null; }
    }

    function setCache(count, items) {
        try {
            sessionStorage.setItem(CACHE_KEY, JSON.stringify({ count: count, items: items, ts: Date.now() }));
        } catch(e) {}
    }

    function clearCache() {
        try { sessionStorage.removeItem(CACHE_KEY); } catch(e) {}
    }

    function updateBadges(count) {
        var badges = document.querySelectorAll('.favourite-badge');
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = count;
            badges[i].style.display = count > 0 ? '' : 'none';
        }
    }

    function markActiveButtons(items) {
        if (!items || !items.length) return;
        var btns = document.querySelectorAll('.btn-favourite');
        for (var i = 0; i < btns.length; i++) {
            var key = btns[i].getAttribute('data-type') + '_' + btns[i].getAttribute('data-id');
            if (items.indexOf(key) !== -1) {
                btns[i].classList.add('active');
                var icon = btns[i].querySelector('i');
                if (icon) icon.className = 'fas fa-heart';
            }
        }
    }

    function applyState(count, items) {
        updateBadges(count);
        markActiveButtons(items);
    }

    function fetchCount() {
        var urls = getUrls();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', urls.count, true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    var count = data.count || 0;
                    var items = data.items || [];
                    setCache(count, items);
                    applyState(count, items);
                } catch(e) {}
            }
        };
        xhr.send();
    }

    function loadFavourites() {
        var cached = getCache();
        if (cached) {
            applyState(cached.count, cached.items);
            return;
        }
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(fetchCount, { timeout: 2000 });
        } else {
            setTimeout(fetchCount, 100);
        }
    }

    function toggleFavourite(btn) {
        if (btn.getAttribute('data-fav-busy')) return;
        btn.setAttribute('data-fav-busy', '1');

        var type = btn.getAttribute('data-type');
        var id = btn.getAttribute('data-id');
        var emirateId = btn.getAttribute('data-emirate') || '';
        var price = btn.getAttribute('data-price') || '';
        var icon = btn.querySelector('i');
        var origClass = icon ? icon.className : '';
        if (icon) icon.className = 'fas fa-spinner fa-spin';

        var urls = getUrls();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', urls.toggle, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', getCsrf());

        xhr.onload = function() {
            btn.removeAttribute('data-fav-busy');
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        updateBadges(data.count);
                        var added = data.added;
                        syncAllButtons(type, id, added);
                        if (added) {
                            showToast('added');
                        } else {
                            showToast('removed');
                        }
                        clearCache();
                    }
                } catch(e) {
                    if (icon) icon.className = origClass;
                }
            } else {
                if (icon) icon.className = origClass;
                // Without this a rate-limited toggle silently reverts and looks broken.
                if (xhr.status === 429) showToast('throttled');
            }
        };

        xhr.onerror = function() {
            btn.removeAttribute('data-fav-busy');
            if (icon) icon.className = origClass;
        };

        var body = { item_type: type, item_id: parseInt(id) };
        if (emirateId) body.emirate_id = parseInt(emirateId);
        if (price) body.price = parseFloat(price);
        xhr.send(JSON.stringify(body));
    }

    function syncAllButtons(type, id, added) {
        var btns = document.querySelectorAll('.btn-favourite[data-type="' + type + '"][data-id="' + id + '"]');
        for (var i = 0; i < btns.length; i++) {
            var icon = btns[i].querySelector('i');
            if (added) {
                btns[i].classList.add('active');
                if (icon) icon.className = 'fas fa-heart';
            } else {
                btns[i].classList.remove('active');
                if (icon) icon.className = 'fal fa-heart';
            }
        }
    }

    function showToast(action) {
        if (typeof Swal === 'undefined') return;
        var isAr = document.documentElement.getAttribute('lang') === 'ar';
        var msg;
        var icon;
        if (action === 'added') {
            msg = isAr ? 'تمت الإضافة إلى المفضلة' : 'Added to Favourites';
            icon = 'success';
        } else if (action === 'throttled') {
            msg = isAr ? 'طلبات كثيرة. يرجى الانتظار قليلاً.' : 'Too many requests. Please wait a moment.';
            icon = 'warning';
        } else {
            msg = isAr ? 'تمت الإزالة من المفضلة' : 'Removed from Favourites';
            icon = 'info';
        }
        Swal.fire({
            toast: true,
            position: isAr ? 'bottom-left' : 'bottom-right',
            icon: icon,
            title: msg,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-favourite');
        if (btn) {
            e.preventDefault();
            e.stopPropagation();
            toggleFavourite(btn);
        }
    }, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadFavourites);
    } else {
        loadFavourites();
    }
})();
