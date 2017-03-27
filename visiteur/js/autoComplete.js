$(document).ready(function () {
    $.ajax({
        url: "/php/ajax.php",
        type: "POST",
        data: 'id=' + $('#id').val(),
        success: function(data) {
            $('#output').html(JSON.stringify(data));
            for (var key in data) {
                $('#'+key).val(data[key])
            }
            calc();
        },  
    });
});