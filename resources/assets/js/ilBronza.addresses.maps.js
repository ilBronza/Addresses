// -------------------------------------------------
// Google Maps lazy loader (load once, on demand)
// -------------------------------------------------

window.__googleMapsLoading = null;

window.loadGoogleMaps = function () {
    // No API key available → do nothing

    if (typeof window.googleMapsApiKey === 'undefined' || !window.googleMapsApiKey) {
        return Promise.reject('Google Maps API key not defined');
    }


    // Already loaded
    if (window.google && window.google.maps) {
        return Promise.resolve();
    }

    // Already loading
    if (window.__googleMapsLoading) {
        return window.__googleMapsLoading;
    }

    // Start loading
    window.__googleMapsLoading = new Promise(function (resolve, reject) {
        var script = document.createElement('script');
        script.src =
            'https://maps.googleapis.com/maps/api/js' +
            '?key=' + window.googleMapsApiKey +
            '&libraries=marker';
        script.async = true;
        script.defer = true;

        script.onload = resolve;
        script.onerror = reject;

        document.head.appendChild(script);
    });

    return window.__googleMapsLoading;
};

// -------------------------------------------------
// Optional preload at app startup
// -------------------------------------------------
if (typeof window.googleMapsApiKey !== 'undefined' && window.googleMapsApiKey) {
    window.loadGoogleMaps().catch(() => {});
}
