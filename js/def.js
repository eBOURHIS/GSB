/**
 * 
 * @file Bibliothéque de fonction js
 * @author Loïc Penaud <lpenaud@zaclys.net>
 * @license {@link https://opensource.org/licenses/Apache-2.0 Apache-2.0}
 * 
 * @requires "jquery-3.1.1.min.js"
 * 
 */

/**
 * 
 * Envois une requête ajax de suppression de champs sql
 * 
 * @param {object} element (DOMElement)
 * 
 * @param {string} msgConfirm - Message de confirmation (confirm())
 * 
 */

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

/**
 * 
 * Permet d'écrire automatiquement le login de l'utilisateur
 *  
 */

function writeLogin() {
    if ($.trim($('#nom').val()) && $.trim($('#prenom').val()) != "") {
        var nom = $('#nom').val().toLowerCase(),
            prenom = $('#prenom').val().toUpperCase();

        $('#login').val(prenom[0] + nom);
    }
}

/**
 * 
 * Permet de générer la fiche frais du visiteur sélectionner.
 * 
 * @param {requestCallback} callback - Le callback qui s'éxecute à la fin de la fonction pour bien afficher le tableau après la fonction
 *  
 */
 
function tableFrais(callback) {
    var date = $("#selectMois").val().split('-');

    console.log(date);
    
    $('#TableauFiche').slideUp('slow');

    $.ajax({
        url: "/ajax/Frais.php",
        type: "POST",
        data: {
            idVisiteur: $("#selectVisiteur").val(),
            mois: date[0],
            annee: date[1],
        },
        success: function(data) {
            console.log(data);
            $("th,td").remove();

            for (var key in data[1]) {
                $("#entete").append('<th>' + data[1][key]['libelle'] + "</th>");
                $("#corps").append('<td>' + data[1][key]['quantite'] + "</td>");
            }

            for (var key in data[0]) {
                if (key == 'id') {
                    continue;
                }
                $("#entete").append('<th>' + key + "</th>");
                $("#corps").append('<th>' + data[0][key] + "</th>");
            }

            $("#entete").append('<th>' + 'Situation' + "</th>");
            $("#corps").append('<td>' + '<input type="radio" id="' + data[0]['id'] + '" name="RadioTableau" value="true" required="required" /> Valide' + '<input type="radio" name="RadioTableau" value="false" /> Non valide' + "</td>");
            $('#TableauFiche').slideDown('slow');
            callback();
        }
    });
}

/**
 * 
 * Cette fonction permet de créer un "hint" / "placeholder" (indice) sur un menu HTML select
 * 
 * @param {objet} element - (DOMElement) Menu HTML select dont on veux rajouter un "placeholder"
 * 
 * @param {string} msg - Message à mettre dans le "placeholder"
 * 
 */

function selectHint(element, msg) {
    $(element).prepend("<option value='' disabled='disabled' selected='selected'>" + msg + "</option>");
}