(function() {
    'use strict';

    var metaUrl = document.querySelector('meta[name="translate-url"]');
    var TRANSLATE_URL = metaUrl ? metaUrl.getAttribute('content') : '/admin/translate';

    function getCSRFToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function getTinyEditor(el) {
        if (typeof tinymce === 'undefined') return null;
        if (!el.id) return null;
        return tinymce.get(el.id) || null;
    }

    function getFieldValue(el) {
        var editor = getTinyEditor(el);
        if (editor) {
            return editor.getContent({ format: 'text' }).trim();
        }
        return (el.value || '').trim();
    }

    function setFieldValue(el, value) {
        var editor = getTinyEditor(el);
        if (editor) {
            editor.setContent('<p>' + value.replace(/\n/g, '</p><p>') + '</p>');
            return;
        }
        if (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT') {
            el.value = value;
            el.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    function translateField(btn) {
        var sourceId = btn.getAttribute('data-translate-source');
        var targetId = btn.getAttribute('data-translate-target');
        var sourceEl = document.querySelector('[name="' + sourceId + '"]');
        var targetEl = document.querySelector('[name="' + targetId + '"]');

        if (!sourceEl || !targetEl) return;

        var text = getFieldValue(sourceEl);
        if (!text) {
            targetEl.focus();
            return;
        }

        var icon = btn.querySelector('i');
        var origClass = icon ? icon.className : '';
        if (icon) { icon.className = 'fa fa-spinner fa-spin'; }
        btn.disabled = true;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', TRANSLATE_URL, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', getCSRFToken());

        xhr.onload = function() {
            btn.disabled = false;
            if (icon) { icon.className = origClass; }

            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success && data.translation) {
                        setFieldValue(targetEl, data.translation);
                    } else {
                        console.error('Translation failed:', data.message || 'Unknown error');
                    }
                } catch(e) {
                    console.error('Translation response parse error:', e);
                }
            } else {
                console.error('Translation HTTP error:', xhr.status, xhr.responseText);
            }
        };

        xhr.onerror = function() {
            btn.disabled = false;
            if (icon) { icon.className = origClass; }
            console.error('Translation network error');
        };

        xhr.send(JSON.stringify({ text: text, from: 'en', to: 'ar' }));
    }

    function translateAll() {
        var btns = document.querySelectorAll('.auto-translate-btn');
        var i = 0;
        function next() {
            if (i >= btns.length) return;
            var btn = btns[i];
            var sourceEl = document.querySelector('[name="' + btn.getAttribute('data-translate-source') + '"]');
            if (sourceEl && getFieldValue(sourceEl)) {
                translateFieldWithCallback(btn, function() {
                    i++;
                    setTimeout(next, 300);
                });
            } else {
                i++;
                next();
            }
        }
        next();
    }

    function translateFieldWithCallback(btn, callback) {
        var sourceId = btn.getAttribute('data-translate-source');
        var targetId = btn.getAttribute('data-translate-target');
        var sourceEl = document.querySelector('[name="' + sourceId + '"]');
        var targetEl = document.querySelector('[name="' + targetId + '"]');

        if (!sourceEl || !targetEl) { callback(); return; }

        var text = getFieldValue(sourceEl);
        if (!text) { callback(); return; }

        var icon = btn.querySelector('i');
        var origClass = icon ? icon.className : '';
        if (icon) { icon.className = 'fa fa-spinner fa-spin'; }
        btn.disabled = true;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', TRANSLATE_URL, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', getCSRFToken());

        xhr.onload = function() {
            btn.disabled = false;
            if (icon) { icon.className = origClass; }
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success && data.translation) {
                        setFieldValue(targetEl, data.translation);
                    }
                } catch(e) { /* ignore parse errors */ }
            }
            callback();
        };

        xhr.onerror = function() {
            btn.disabled = false;
            if (icon) { icon.className = origClass; }
            callback();
        };

        xhr.send(JSON.stringify({ text: text, from: 'en', to: 'ar' }));
    }

    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.auto-translate-btn');
        if (btn) {
            e.preventDefault();
            translateField(btn);
            return;
        }
        var allBtn = e.target.closest('.translate-all-btn');
        if (allBtn) {
            e.preventDefault();
            var icon = allBtn.querySelector('i');
            if (icon) { icon.className = 'fa fa-spinner fa-spin'; }
            allBtn.disabled = true;
            translateAll();
            setTimeout(function() {
                allBtn.disabled = false;
                if (icon) { icon.className = 'fa fa-language'; }
            }, document.querySelectorAll('.auto-translate-btn').length * 500 + 1000);
        }
    });
})();
