function cmEstimateParticipants(e) {
    e.preventDefault();

    var link = (jQuery(this).attr('href'));

    window.open(link, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400');
    return false;
}

function cmWidgetMap(selector) {
    var $map = jQuery('#' + selector);

    var latitude = $map.data('latitude');
    var longitude = $map.data('longitude');
    var centerLatLng = [latitude, longitude];

    var map = L.map(selector).setView(centerLatLng, 13);

    alert(centerLatLng);


    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker(centerLatLng).addTo(map)
        .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        .openPopup();
}

window.onload = function () {
    jQuery('.criticalmass-estimate-link').click(cmEstimateParticipants);

    cmWidgetMap('criticalmass-widget-map');
};
