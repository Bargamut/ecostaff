/**
 * User: Bargamut
 * Date: 09.10.12
 * Time: 0:32
 */

$(function() {
    init();
    toggleInputs($('#lvl'));

    $('#lvl').livequery('change', function() { toggleInputs($(this)); });
});

function toggleInputs(obj) {
    switch (obj.val()) {
        case 'T':
            $('#login, #filial, #pass, #pass2').parent().hide();
            $('#phone, #metro, #grade').parent().show();
            $('.langs').show();
            break;
        default:
            $('.langs').hide();
            $('#phone, #metro, #grade').parent().hide();
            $('#login, #filial, #pass, #pass2').parent().show();
            break;
    }
}

/**
 * Функция инициализации формы редактирования
 */
function init() {
    if ($('.status').val() == 'new') {
        $('.submEdit, .submClose').parent().remove();
    } else {
//        $('#number, #cost, #date, #filial, #hours, #payvariant').attr('disabled', true);
//        $('.etap').each(function() {
//            if ($(this).val() > 0) { $(this).attr('readonly', true); }
//        });
        $('.submBut').parent().remove();
    }
}