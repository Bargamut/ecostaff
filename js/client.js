/**
 * User: Bargamut
 * Date: 23.11.12
 * Time: 20:56
 */

$(function() {
    $('.clients > li').draggable({
        appendTo: '.clients',
        addClasses: false,
        helper: 'clone',
        revert: 'invalid'
    });
    $('.groups > li, .groups > li > ul.ingroup').droppable({
        activeClass: 'place2drop',
        hoverClass: 'hover2drop',
        addClasses: false,
        accept: ':not(.ui-sortable-helper)',
        over: function() {},
        drop: function(event, ui) {
            var eid = ui.draggable.attr('rel'), text = ui.draggable.text();
            add2group($(this), eid, text);
        }
    }).sortable({
        items: 'li:not(.placeholder)',
        sort: function() {
            // gets added unintentionally by droppable interacting with sortable
            // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
            $(this).removeClass('ui-state-default');
        }
    });

    $('.groups > li').livequery('click', function() { groupsClick($(this)); });
    $('.clients > li').livequery('click', function() { clientsClick($(this)); });

    $('#btnSubm').livequery('click', function() { submForm('insert'); return false; });
    $('#btnEdit').livequery('click', function() { submForm('update'); return false; });
});

function clientsClick(obj) {
    editPrepareClient(obj.attr('rel'));
    if (!obj.hasClass('new')) { getClient(obj); }
}
function groupsClick(obj) {
    editPrepareGroup(obj.attr('rel'));
    if (!obj.hasClass('new')) { getGroup(obj); }
}

/**
 * Переключение списка клиентов в группе
 * @param obj - <li> группы
 */
function getGroup(obj) {
    var clients = obj.find('.ingroup > li');

    obj.toggleClass('selected')
        .siblings().removeClass('selected');

    $('.clients > li').removeClass('inGroup selected');
    $('.groups > li').removeClass('hasClient');

    if (clients.length != 0) {
        for (var i in clients) {
            $('.clients > li:not(".new")').eq(clients.eq(i).attr('rel') - 1).toggleClass('inGroup');
        }
    }
}

/**
 * Информация о клиенте
 * @param obj - <li> клиента
 */
function getClient(obj) {
    obj.toggleClass('selected')
        .siblings().removeClass('selected');

    $('.groups > li').removeClass('hasClient selected');
    $('.clients > li').removeClass('inGroup');

    if ($('.clients > li.selected').length != 0) {
        $('.groups > li:not(".new")').each(function() {
            var o = $(this);
            o.find('.ingroup > li').each(function() {
                if ($(this).attr('rel') == obj.attr('rel')) {
                    o.toggleClass('hasClient');
                }
            });
        });
    }
}

function editPrepareClient(cid) {
    clearForm();
    if (cid == 'new') {
        $('#cid').val('new');
        $('#btnSubm').show();
        $('#btnEdit').hide();
    } else {
        $('#cid').val(cid);
        $('#btnEdit').show();
        $('#btnSubm').hide();
        $.ajax({
            url: '/client/action.php',
            type: 'POST',
            data: 'mode=select&cid=' + cid,
            dataType: 'json',
            complete: function(data) {
                data = JSON.parse(data.responseText);

                $('#fio').val(data.fio);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#skype').val(data.skype);
                $('#note').val(data.note);
            },
            error: function() {}
        });
    }

    $('#cgEditor > .client').show().children().removeAttr('disabled');
    $('#cgEditor > .group').hide().children().attr('disabled', true);
}

function editPrepareGroup(gid) {
    clearForm();
    if (gid == 'new') {
        $('#gid').val('new');
        $('#btnSubm').show();
        $('#btnEdit').hide();
    } else {
        $('#gid').val(gid);
        $('#btnEdit').show();
        $('#btnSubm').hide();
        $.ajax({
            url: '/client/action.php',
            type: 'POST',
            data: 'mode=select&gid=' + gid,
            dataType: 'json',
            complete: function(data) {
                data = JSON.parse(data.responseText);

                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#skype').val(data.skype);
                $('#note').val(data.note);
            },
            error: function() {}
        });
    }

    $('#cgEditor > .group').show().children().removeAttr('disabled');
    $('#cgEditor > .client').hide().children().attr('disabled', true);
}

function submForm(mode) {
    var p = 'mode=' + mode +
            '&cid=' + $('#cid').val() +
            '&gid=' + $('#gid').val() +
            '&name=' + encodeURIComponent($('#name').val()) +
            '&fio=' + encodeURIComponent($('#fio').val()) +
            '&phone=' + encodeURIComponent($('#phone').val()) +
            '&email=' + encodeURIComponent($('#email').val()) +
            '&skype=' + encodeURIComponent($('#skype').val()) +
            '&note=' + encodeURIComponent($('#note').val());
    $.ajax({
        url: '/client/action.php',
        type: 'POST',
        data: p,
        dataType: 'json',
        complete: function(data) {
            data = JSON.parse(data.responseText);

        },
        error: function() {}
    });
}

function clearForm() {
    $('#cgEditor > li').not('.submit').children().val('').removeAttr('selected');
}

function add2group(obj, eid, text) {
    if (obj.hasClass('ingroup')) {
        if (obj.children('[rel="' + eid + '"]').length == 0) {
            obj.find('.placeholder').remove();
            obj.append($('<li></li>').text(text).attr('rel', eid));
        }
    } else {
        obj = obj.children('.ingroup');
        add2group(obj, eid, text);
    }
}