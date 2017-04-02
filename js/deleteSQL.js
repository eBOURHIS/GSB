$(document).ready(function () {
    $("img[alt='supprimer']").click(function () {
        if (confirm("Désirez-vous vraiment supprimer cette utilisateur ?")) {
            var id = $("img[alt='supprimer']").attr('id').substr(5);
            console.log(id);
            $("table").fadeOut("slow");
            $("#chargement").fadeIn("slow")
            $.ajax({
                url: "/ajax/deleteTable.php",
                type: "POST",
                data: {id: id, table: $("table").attr('id')},
                success: function(data) {
                    console.log(JSON.stringify(data));
                    $('#tr'+id).hide();
                    $('#chargement').fadeOut("slow")
                    $("h5.invisible").fadeIn("slow")
                    $("table").fadeIn("slow");
                },
            });
        }
    });
});