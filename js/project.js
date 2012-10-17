/**
 * User: Bargamut
 * Date: 03.10.12
 * Time: 19:34
 */

$(function() {
    init();
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