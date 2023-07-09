/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', "#reload-cahce", function (e) {
    location.reload();
});

$(document).on('click', '#clear-cahce', function (e) {
    e.preventDefault();
    var element = this;

    var url = $(this).attr('data-url');

    var method = 'post';

    var enctype = 'application/x-www-form-urlencoded';

    $.ajax({
        url: url,
        type: method,
        data: {data: 1},
        dataType: 'json',
        cache: false,
        contentType: enctype,
        processData: false,
        beforeSend: function () {

        },
        complete: function () {

        },
        success: function (json) {

            if (json.reload) {
                location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});

