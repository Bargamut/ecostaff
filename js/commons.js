/**
 * User: Bargamut
 * Date: 19.10.12
 * Time: 10:41
 */

$(function() {
    $('.tools li').livequery('click', function() { window.location.href = $(this).find('a').attr('href'); });
});