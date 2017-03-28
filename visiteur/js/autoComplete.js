$(document).ready(function () {
    $("h4.invisible").show();
    $("#formulaire").hide();
    
    $.ajax({
        url: "/php/ajax.php",
        type: "POST",
        data: 'id=' + $('#id').val(),
        success: function(data) {
            console.log(JSON.stringify(data));
            
            for (var key in data) {
                $('#'+key).val(data[key]);
            }
            calc();
            $('#calculer').attr('name','update');
            // for (var i = 1; i < tr.length; i++) {
            //     $(tr[i]).delay(800).slideDown("slow");
            // }
            $("h4.invisible").slideUp(1200);
            $("#formulaire").slideDown(1200);
        }
    });
});