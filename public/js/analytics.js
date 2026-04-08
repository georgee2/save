(function() {
    'use strict';

    var HEARTBEAT_INTERVAL = 30000;
    var startTime = Date.now();
    var heartbeatTimer = null;
    var pageViewId = null;
    var baseUrl = document.querySelector('meta[name="analytics-heartbeat-url"]');

    if (!baseUrl) return;
    baseUrl = baseUrl.getAttribute('content');

    function getTimeOnPage() {
        return Math.round((Date.now() - startTime) / 1000);
    }

    function sendHeartbeat() {
        var data = JSON.stringify({
            time_on_page: getTimeOnPage(),
            url: window.location.href,
            title: document.title
        });

        if (navigator.sendBeacon) {
            navigator.sendBeacon(baseUrl, new Blob([data], { type: 'application/json' }));
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', baseUrl, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(data);
        }
    }

    heartbeatTimer = setInterval(sendHeartbeat, HEARTBEAT_INTERVAL);

    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'hidden') {
            sendHeartbeat();
            clearInterval(heartbeatTimer);
        } else {
            startTime = Date.now() - (getTimeOnPage() * 1000);
            heartbeatTimer = setInterval(sendHeartbeat, HEARTBEAT_INTERVAL);
        }
    });

    window.addEventListener('beforeunload', function() {
        sendHeartbeat();
    });
})();
