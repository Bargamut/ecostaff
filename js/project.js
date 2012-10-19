/**
 * User: Bargamut
 * Date: 03.10.12
 * Time: 19:34
 */

$(function() {
    init();

//    $('.subhead').livequery('click', function() { showhide($(this)); });
});

/**
 * Функция инициализации формы редактирования
 */
function init() {
    if ($('.status').val() == 'new') {
        $('.submEdit, .submClose').parent().remove();

        $.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
        $('#date').datepicker();
    } else {
        $('#number').attr('readonly', true);
        $('#cost, #date, #filial, #hours, #payvariant').attr('disabled', true);
        $('.payed').attr('readonly', true);
        $('.submBut').parent().remove();
    }
}

function showhide(obj) {
    var ulblock = obj.find('ul');

    if (ulblock.is(':visible')) {
        ulblock.hide();
    } else {
        $('.subhead > ul').hide();
        ulblock.show();
    }
}