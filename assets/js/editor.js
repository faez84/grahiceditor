/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

$(function() {
   const shapes = new Array();

    function initializeData()
    {
        let params = {
            color:$('#color').val(),
            border:$('#border').val(),
            size:$('#size').val(),
            xPosition:$("#xPosition").val(),
            yPosition:$("#xPosition").val()
        };
        return params
    }
    $("#addCircleBtn").on('click', function()  {
        let params = initializeData();
        params['radius'] = $("#radius").val();
        let shape = {type:'circle', params:params}
        shapes.push(shape);
    });
    $("#addSquareBtn").on('click', function()  {
        let params = initializeData();
        params['length'] = $("#length").val();
        let shape = {type:'square', params:params}
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
                $('#drawPanel').append(xhr.responseText + ': An error happened while adding shapes, please try again ' +
                    'or check if you added any shape before');
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