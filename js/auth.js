/**
 * User: Bargamut
 * Date: 14.07.12
 * Time: 4:08
 */
$(function() {
    // Для страницы авторизации
    $('#login, #pass').focus(function() {
        if ($(this).val() == 'Логин' || $(this).val() == 'Пароль') { $(this).val(''); }
    });
    $('#login').blur(function() {
        if ($(this).val() == '') { $(this).val('Логин'); }
    });
    $('#pass').blur(function() {
        if ($(this).val() == '') { $(this).val('Пароль'); }
    });

    // Для миниавторизации
    $('#maEmail, #maPass').focus(function() {
        if ($(this).val() == 'E-Mail' || $(this).val() == 'Пароль') { $(this).val(''); }
        deform($(this), '+');
    });
    $('#maEmail').blur(function() {
        if ($(this).val() == '') { $(this).val('E-Mail'); }
        deform($(this), '-');
    });
    $('#maPass').blur(function() {
        if ($(this).val() == '') { $(this).val('Пароль'); }
        deform($(this), '-');
    });
});

/**
 * Деформация ширины объектов
 * @param o - объект
 * @param k - увеличить / уменьшить
 */
function deform(o, k){ o.stop().animate({ width: k + "=100px" }, 300); }