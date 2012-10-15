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

    if ($('#datebeg').val() != '')  { p.push('datebeg=' + dateForm($('#datebeg').val())); }
    if ($('#dateend').val() != '')  { p.push('dateend=' + dateForm($('#dateend').val())); }
    if ($('#numbeg').val() != '')   { p.push('numbeg=' + $('#numbeg').val()); }
    if ($('#numend').val() != '')   { p.push('numend=' + $('#numend').val()); }
    if ($('#form').val() != 0)      { p.push('form=' + $('#form').val()); }
    if ($('#payvariant').val() != 0){ p.push('payvariant=' + $('#payvariant').val()); }
    if ($('#manager').val() != 0)   { p.push('manager=' + $('#manager').val()); }

    param = '?' + p.join('&');

    if (param.length <= 1) { param = ''; }
    dLoc.href = dLoc.href.split('?')[0] + param;
}

function init() {
    if ($('#datebeg').val() != '')  { $('#datebeg').val(dateFormR($('#datebeg').val())); }
    if ($('#dateend').val() != '')  { $('#dateend').val(dateFormR($('#dateend').val())); }
}