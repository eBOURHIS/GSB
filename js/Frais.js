$('#selectVisiteur').change(function() {
    console.log($('#selectVisiteur').val());

    $('#FieldsetSelect').fadeOut('slow');
    $('#chargementUp').fadeIn('slow');
    $('#TableauFiche').fadeOut('slow');

    $.ajax({
        url: "/ajax/Frais.php",
        type: "POST",
        data: {
            idVisiteur: $("#selectVisiteur").val()
        },
        success: function(data) {
            $("#selectMois > option").remove();
            console.log(data);

            for (var i = 0; i < data.length; i++) {
                $('#selectMois').append($('<option/>', {
                    value: data[i].mois + '-' + data[i].annee,
                    text: data[i].mois + '-' + data[i].annee
                }));
            }

            if (data.length == 1) {
                tableFrais();
            }
            else {
                selectHint('#selectMois', "Sélectionner un mois");
            }

            $('#chargementUp').fadeOut('slow');
            $('#FieldsetSelect').fadeIn('slow');
            $('#selectMois').fadeIn('slow');
        }
    });
});

$('#selectMois').change(function() {
    $('#TableauFiche').slideUp('slow');
    $('#chargementDown').fadeIn('slow', function() {
        tableFrais(function() {
            $('#chargementDown').slideUp('slow');
        });
    });
});


$('#ValiderFicheFrais').click(function() {
    var valide = $('input[type="radio"]:checked').val();
    console.log(valide);
    if (valide) {
        if (valide == "true") {
            location.replace('/comptable/MettreEnPaiement.php?id=' + $('input[type="radio"]:checked').attr('id'));
        }
    }
    else {
        alert('Veuillez sélectionner "Valide" ou "Non Valide".');
    }
});
