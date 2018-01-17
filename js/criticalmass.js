function cmEstimateParticipants(e) {
    e.preventDefault();

    var link = (jQuery(this).attr('href'));

    window.open(link, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400');
    return false;
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

    var map = L.map(selector).setView(centerLatLng, 13);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker(centerLatLng).addTo(map)
        .bindPopup(popupContent)
        .openPopup();
}

window.onload = function () {
    jQuery('.criticalmass-estimate-link').click(cmEstimateParticipants);

    cmWidgetMap('criticalmass-widget-map');
};
