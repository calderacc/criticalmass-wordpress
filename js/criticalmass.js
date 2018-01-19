function cmEstimateParticipants(e) {
    e.preventDefault();

    var $link = jQuery(this);
    var url = ($link.attr('href'));

    var popup = window.open(url, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400');

    var timer = setInterval(function() {
        if(popup.closed) {
            clearInterval(timer);
            refreshEstimatedParticipants($link);
        }
    }, 500);

    return false;
}

function refreshEstimatedParticipants($link) {
    var url = $link.attr('href');
    url = url.replace('https://criticalmass.in/', 'https://criticalmass.in/api/').replace('/anonymousestimate', '');
    
    jQuery.ajax({
        dataType: 'json',
        url: url,
        success: function(rideData) {
            var estimatedParticipants = rideData.estimatedParticipants;

            if (estimatedParticipants) {
                $link.parent().append(estimatedParticipants);
                $link.remove();
            }
        }
    });
}

function cmWidgetMap(selector) {
    var $map = jQuery('#' + selector);

    var title = $map.data('title');
    var location = $map.data('location');
    var citySlug = $map.data('city-slug');
    var dateTime = new Date($map.data('dateTime') * 1000);
    var latitude = $map.data('latitude');
    var longitude = $map.data('longitude');
    var centerLatLng = [latitude, longitude];

    var rideDate = dateTime.toISOString().split('T')[0];
    var rideLink = 'https://criticalmass.in/' + citySlug + '/' + rideDate;

    var popupContent = '<a href="' + rideLink + '"><strong>' + title + '</strong></a><br />';
    popupContent += '<strong>Datum:</strong> ' + dateTime.toLocaleString() + ' Uhr<br />';
    popupContent += '<strong>Treffpunkt:</strong> ' + location;

    var map = L.map(selector, { zoomControl: false }).setView(centerLatLng, 13);

    L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png', {
        attribution: 'Wikimedia maps beta | Map data &copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.marker(centerLatLng).addTo(map)
        .bindPopup(popupContent)
        .openPopup();
}

window.onload = function () {
    jQuery('.criticalmass-estimate-link').click(cmEstimateParticipants);

    jQuery('.criticalmass-widget-map').each(function() {
        var elementId = jQuery(this).attr('id');

        cmWidgetMap(elementId);
    });
};
