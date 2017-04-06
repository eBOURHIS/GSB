function deleteSQL(element, msgConfirm) {
    var err = false;

    if (typeof(msgConfirm) != "string") {
        console.error("string required (msgConfirm)");
        err = true;
    }

    if (!err && confirm(msgConfirm)) {
        var id = $(element).attr('id').substr(5);
        console.log(id);

        $("table").fadeOut("slow");
        $("h5.invisible").fadeOut("slow");
        $("#chargement").fadeIn("slow");

        $.ajax({
            url: "/ajax/deleteTable.php",
            type: "POST",
            data: {
                id: id,
                table: $("table").attr('id')
            },
            success: function(data) {
                console.log(JSON.stringify(data));
                $('#chargement').fadeOut("slow");

                if (data['affected']) {
                    $('#tr' + id).hide();
                    $("h5.invisible").css("color", "green");
                    $("h5.invisible").text("Mise à jour effectué");
                }
                else {
                    $("h5.invisible").css("color", "red");
                    $("h5.invisible").text("Mise-à-jour échoué");
                }

                $("h5.invisible").fadeIn("slow");
                $("table").fadeIn("slow");
            },
        });
    }
}
