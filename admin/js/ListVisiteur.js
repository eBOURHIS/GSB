$(document).ready(function() {
    var date;
    
    if ($('#id').val()) {
        console.log($('#id').val());
        
        $('#etat').text("Chargement ...").fadeIn('slow').css('color','rgba(0,0,0,.8)');
        $('#formulaire').fadeOut('slow');
        
        $.ajax({
            url: "/admin/ajax/GestionVisiteur.php",
            type: "POST",
            data: {id: $('#id').val()},
            success: function (data) {
                var tmp;
                console.log(data);
                for (var key in data['res']) {
                    if (key == 'dateEmbauche') {
                        tmp = data['res'][key].split('-');
                        console.log(tmp);
                        $('#jour option[value="' + parseInt(tmp[2]) + '"]').prop('selected', true);
                        $('#mois option[value="' + parseInt(tmp[1]) + '"]').prop('selected', true);
                        $('#annee option[value="' + tmp[0] + '"]').prop('selected', true);
                    } else {
                        $('#' + key).val(data['res'][key]);
                    }
                }
                $('#insert').attr('name','update').attr('id','update');
                $('#etat').fadeOut('slow');
                $('#formulaire').fadeIn('slow');
            }
        });
    } else {
        date = new Date();
        $('#jour option[value="' + date.getDate() + '"]').prop('selected', true);
        $('#mois option[value="' + parseInt(date.getMonth() + 1) + '"]').prop('selected', true);
        $('#annee option[value="' + date.getFullYear() + '"]').prop('selected', true);
    }
    
    $('#nom').blur(function() {
        writeLogin();
    });
    
    $('#prenom').blur(function() {
        writeLogin();
    });
    
    $('input[type="text"]').blur(function () {

        if (!this.checkValidity()) {
            
            if ($('#error' + this.id).length) {
                $('#error' + this.id).html(this.validationMessage + '<br />');
            } else {
                $(this).before("<strong class='error' id='" + "error" + this.id + "'>" + this.validationMessage + "<br /></strong>");
            }
            
        } else {
            $('#error' + this.id).remove();
        }
        
    });
    
    $('input[type="button"]').click(function () {
        var check = false, inputs = $('input[type="text"]'), jsonData = {};
        
        for (var i = 0; i < inputs.length; i++) {
            if (!inputs[i].checkValidity()) {
                check = true;
                break;
            }
            jsonData[inputs[i].id] = inputs[i].value;
        }
        
        if (check) {
            alert("Veuillez bien remplir le formulaire.");
        } else {
            jsonData['nom'] = $('#nom').val().toUpperCase();
            jsonData['prenom'] = $('#prenom').val()[0].toUpperCase() + $('#prenom').val().substr(1);
            jsonData['ville'] = $('#ville').val().toUpperCase();
            jsonData['dateEmbauche'] = $('#annee').val() + '-' + $('#mois').val() + '-' + $('#jour').val();
            jsonData['adresse'] = $('#adresse').val().toLowerCase();
            if (this.id == 'update') {
                jsonData['id'] = $("#id").val();
            } else {
                jsonData['id'] = $('#nom').val()[0].toUpperCase() + $('#prenom').val()[0].toUpperCase();
            }
            jsonData['pwd'] = "";
            jsonData[this.id] = true;
            delete jsonData['annee'];
            delete jsonData['mois'];
            delete jsonData['jour'];
            // console.log(jsonData);
            
            $('#etat').text("Chargement ...").fadeIn('slow').css('color','rgba(0,0,0,.8)');
            $('#formulaire').fadeOut('slow');
            $.ajax({
                url: "/admin/ajax/GestionVisiteur.php",
                type: "POST",
                data: jsonData,
                success: function (data) {
                    console.log(data);
                    
                    if (data['res']) {
                        $('#etat').text("Mise-à-jour réussi !").fadeIn('slow').css('color','green');
                        if (data['pwd']) {
                            $('#h3pwd').append("Mot de passe généré : <strong>" + data['pwd'] + '</strong>').fadeIn('slow');
                        }
                    } else {
                        $('#etat').text("Mise-à-jour échoué !").fadeIn().css('color','red');
                    }
                    
                    $('#formulaire').fadeIn('slow');
                    window.scroll(0,0);
                }
            });
        }
        
    });
});