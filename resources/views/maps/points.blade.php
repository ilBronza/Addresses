<div id="map" style="height: 600px; width: 100%;"></div>

<script>
// AJAX-safe namespace for delivery map
window.__ibDeliveryMap = window.__ibDeliveryMap || {};
var DeliveryMap = window.__ibDeliveryMap;

/**
 * Example delivery points.
 * In real usage, inject these from the controller.
 */
DeliveryMap.stops = {!! json_encode($stops) !!};

window.ibInitDeliveryMap = function (container) {
    if (!container) {
        return;
    }

    const mapEl = container.querySelector('#map');
    if (!mapEl) {
        return;
    }

    if (mapEl.dataset.initialized) {
        return;
    }

    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        // Google Maps API not yet available – retry shortly
        setTimeout(() => window.ibInitDeliveryMap(container), 100);
        return;
    }

    mapEl.dataset.initialized = '1';
    initMap();
};

window.ibFetcherInit = function (container) {

    if (!container) {
        return;
    }

    if (typeof window.ibInitDeliveryMap === 'function') {

        window.ibInitDeliveryMap(container);
    }
};

function initMap() {
    DeliveryMap.map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: DeliveryMap.stops[0] ?? { lat: 45.49, lng: 12.24 },
        mapId: '{{ config('services.google.maps_map_id') }}',
        styles: [
            {
                featureType: 'poi',
                stylers: [{ visibility: 'off' }]
            },
            {
                featureType: 'transit',
                stylers: [{ visibility: 'off' }]
            },
            {
                featureType: 'road',
                elementType: 'labels.icon',
                stylers: [{ visibility: 'off' }]
            }
        ]
    });

    DeliveryMap.directionsService = new google.maps.DirectionsService();

    // Background outline (dark, thicker)
    DeliveryMap.directionsRendererOutline = new google.maps.DirectionsRenderer({
        map: DeliveryMap.map,
        suppressMarkers: true,
        preserveViewport: true,
        polylineOptions: {
            strokeColor: '#000000',
            strokeOpacity: 0.6,
            strokeWeight: 10
        }
    });

    // Foreground route (bright, thinner)
    DeliveryMap.directionsRenderer = new google.maps.DirectionsRenderer({
        map: DeliveryMap.map,
        suppressMarkers: false,
        polylineOptions: {
            strokeColor: '#1e87f0', // UIkit primary
            strokeOpacity: 1,
            strokeWeight: 5
        }
    });

    placeMarkers(DeliveryMap.stops);
    drawRoute(DeliveryMap.stops);
}

function placeMarkers(points) {
    points.forEach((point, index) => {
        const markerEl = document.createElement('div');
        markerEl.className = 'delivery-marker';
        markerEl.innerHTML = `
            <div class="delivery-marker-index">${index + 1}</div>
            <div class="delivery-marker-label">${point.label ?? ''}</div>
        `;

        new google.maps.marker.AdvancedMarkerElement({
            map: DeliveryMap.map,
            position: { lat: point.lat, lng: point.lng },
            content: markerEl
        });
    });
}

function drawRoute(points) {
    if (points.length < 2) {
        return;
    }

    const origin = points[0];
    const destination = points[points.length - 1];

    const waypoints = points.slice(1, -1).map(point => ({
        location: new google.maps.LatLng(point.lat, point.lng),
        stopover: true
    }));

    DeliveryMap.directionsService.route({
        origin: origin,
        destination: destination,
        waypoints: waypoints,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
    }, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            DeliveryMap.directionsRendererOutline.setDirections(result);
            DeliveryMap.directionsRenderer.setDirections(result);
            logRouteSummary(result);
        } else {
            console.error('Directions request failed:', status);
        }
    });
}

function logRouteSummary(result) {
    const route = result.routes[0];
    let totalDistance = 0;
    let totalDuration = 0;

    route.legs.forEach(leg => {
        totalDistance += leg.distance.value;
        totalDuration += leg.duration.value;
    });

    const distanceKm = (totalDistance / 1000).toFixed(2);
    const durationMin = Math.round(totalDuration / 60);

    $(document.querySelector('[data-name="route-distance"]')).text(`${distanceKm} km`);
    $(document.querySelector('[data-name="route-duration"]')).text(`${durationMin} min`);

    const stopNumbers = DeliveryMap.stops.length - 2;

    window.addSuccessNotification(`Total distance: ${distanceKm} km<br />Total duration: ${durationMin} min<br />Destination number: ${stopNumbers}`);
}

</script>
<style>
.delivery-marker {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #1e87f0;
    color: #fff;
    padding: 4px 8px;
    border-radius: 14px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0,0,0,0.35);
    white-space: nowrap;
}

.delivery-marker-index {
    background: rgba(0,0,0,0.25);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 11px;
}

.delivery-marker-label {
    max-width: 140px;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
