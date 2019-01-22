/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

$(function() {
   const shapes = new Array();

    $("#addShapeBtn").on('click', function()  {
        let params = {radius:$("#radius").val(), xPosition:$("#xPosition").val(), yPosition:$("#xPosition").val()};;
        let shape = {type:$("#type").val(), params:params}
        shapes.push(shape);
    });
    $("#addShapesBtn").on('click', function()  {
        $.ajax({
            type: 'POST',
            url: '/addshapes',
            data: {
                shapes: shapes
            },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                $('#drawPanel').append('<div class="col-12 col-md-12">' + result + '</div>');

            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#drawPanel').append(xhr.responseText);
            }
        });
    });

    $("#drawBtn").on('click', function()  {
        $.ajax({
            type: 'GET',
            url: '/draw',
            data: {
                shapes: shapes
            },
            dataType: 'json',
            success: function (result) {
                $('#drawPanel').append('<div class="col-12 col-md-12">' + result + '</div>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#drawPanel').append(xhr.responseText);
            }
        });
    });
});