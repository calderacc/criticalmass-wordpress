function cmEstimateParticipants(e) {
    e.preventDefault();

    var link = (jQuery(this).attr('href'));

    window.open(link, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400');
    return false;
}

window.onload = function () {
    jQuery('.criticalmass-estimate-link').click(cmEstimateParticipants);
};
