/**
 * User: Bargamut
 * Date: 15.10.12
 * Time: 0:12
 */

$(function() {
    init();

    $.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
    $('#datebeg, #dateend').datepicker();
    $('#filtersubm').livequery('click', function() { filters(); });
});

function dateForm(date) {
    return date.split('.').reverse().join('-');
}

function dateFormR(date) {
    return date.split('-').reverse().join('.');
}

function filters() {
    var param, dLoc = window.location, p = new Array();

    if ($('#datebeg').val()     != '') { p.push('datebeg=' + dateForm($('#datebeg').val())); }
    if ($('#dateend').val()     != '') { p.push('dateend=' + dateForm($('#dateend').val())); }

    param = '?' + p.join('&');

    if (param.length <= 1) { param = ''; }
    dLoc.href = dLoc.href.split('?')[0] + param;
}

function init() {
    if ($('#datebeg').val() != '')  { $('#datebeg').val(dateFormR($('#datebeg').val())); }
    if ($('#dateend').val() != '')  { $('#dateend').val(dateFormR($('#dateend').val())); }
}