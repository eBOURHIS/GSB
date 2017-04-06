$(document).ready(function () {
    $("img[alt='supprimer']").click(function () {
        deleteSQL(this, "Désirez-vous vraiment supprimer cette utilisateur ?");
    });
});