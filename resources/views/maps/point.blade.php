@php
    $mapId = $mapId ?? 'destination-map-' . uniqid();
    $stops = isset($point) && $point ? [$point] : [];
    $draggable = $draggable ?? false;
    $latFieldName = $latFieldName ?? 'latitude';
    $lngFieldName = $lngFieldName ?? 'longitude';
@endphp

@if(!empty($addressEditUrl))
    <p class="uk-margin-small-bottom">
        <a href="{{ $addressEditUrl }}" class="uk-link">{{ __('addresses::maps.editAddress') }}</a>
    </p>
@endif

@if($draggable)
    <p class="uk-text-muted uk-margin-small-bottom uk-text-small">{{ __('addresses::maps.dragToAdjust') }}</p>
@endif

<div id="{{ $mapId }}" class="destination-single-point-map" style="height: 400px; width: 100%; min-height: 300px;"
     @if($draggable) data-draggable="1" data-lat-field="{{ $latFieldName }}" data-lng-field="{{ $lngFieldName }}" @endif></div>

@if(empty($stops) && !$draggable)
    <p class="uk-text-muted uk-margin-small-top">{{ __('addresses::maps.noCoordinates') }}</p>
@endif

<script>
(function() {
    var mapId = '{{ $mapId }}';
    var stops = {!! json_encode($stops) !!};
    var draggable = {{ $draggable ? 'true' : 'false' }};
    var latFieldName = '{{ $latFieldName }}';
    var lngFieldName = '{{ $lngFieldName }}';

    window['ibInitDestinationMap_' + mapId] = function(container) {
        if (!container) return;

        var mapEl = container.querySelector('#' + mapId);
        if (!mapEl || mapEl.dataset.initialized) return;

        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            setTimeout(function() { window['ibInitDestinationMap_' + mapId](container); }, 100);
            return;
        }

        mapEl.dataset.initialized = '1';

        var defaultCenter = { lat: 45.49, lng: 12.24 };
        var center = stops[0] || defaultCenter;
        var map = new google.maps.Map(mapEl, {
            zoom: 15,
            center: center,
            mapId: '{{ config('services.google.maps_map_id', '') }}' || undefined,
            styles: [
                { featureType: 'poi', stylers: [{ visibility: 'off' }] },
                { featureType: 'transit', stylers: [{ visibility: 'off' }] }
            ]
        });

        var markerPosition = stops.length > 0
            ? { lat: parseFloat(stops[0].lat), lng: parseFloat(stops[0].lng) }
            : defaultCenter;

        var marker = new google.maps.Marker({
            map: map,
            position: markerPosition,
            title: stops.length > 0 ? (stops[0].label || '') : '',
            draggable: draggable
        });

        if (draggable) {
            marker.addListener('dragend', function() {
                var pos = marker.getPosition();
                var latInput = document.querySelector('input[name="' + latFieldName + '"], input[name*="[' + latFieldName + ']"]');
                var lngInput = document.querySelector('input[name="' + lngFieldName + '"], input[name*="[' + lngFieldName + ']"]');
                if (latInput) latInput.value = pos.lat().toFixed(7);
                if (lngInput) lngInput.value = pos.lng().toFixed(7);
            });
        }
    };

    function runInit() {
        var initFn = window['ibInitDestinationMap_' + mapId];
        if (initFn) {
            var container = document.querySelector('.fieldset-container-parameters, [data-fieldset-container]') || document;
            initFn(container);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runInit);
    } else {
        runInit();
    }

    var prevFetcherInit = window.ibFetcherInit;
    window.ibFetcherInit = function(container) {
        if (prevFetcherInit) prevFetcherInit(container);
        runInit();
    };
})();
</script>

