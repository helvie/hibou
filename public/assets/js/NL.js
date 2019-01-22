

// Fonction mailChimp
(function($)
{window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';
fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));
var $mcj = jQuery.noConflict(true);

// Au clic sur le faux bouton, remplissage des champs mail et nom cachés, déclenchement de la fonction d'enregistremet
// en BDD et de la validation mailChimp
$("#falseButton").on("click",function(){

    if($("#mce-FNAME").val()==""){
        alert("Vous devez remplir de champ nom");
    }
    else if ($("#mce-EMAIL").val() == "") {
            alert("Vous devez remplir de champ email");
        }
    else if($("#rgpdNL").prop("checked")==false){
        alert("Vous devez cocher la case RGPD pour pouvoir continuer l'inscription")
    }
    else {
    nameNL = $("#mce-FNAME").val();
    mailNL = $("#mce-EMAIL").val();
    $("#mc-embedded-subscribe").trigger("click");
    owlPropectNLRegistred(nameNL, mailNL);
    $("#mce-success-response").remove();
    }
});


// Envoi des variables nom et mail, vers le controleur d'enregistrement en BDD
function owlPropectNLRegistred(nameNL, mailNL) {
    console.log(nameNL +" - "+ mailNL);
    jQuery.ajax({
        url: "owlPropectNLRegistred",
        type: "POST",
        data:
            {

                nameNL: nameNL,
                mailNL: mailNL,
            },
        dataType: 'json',

        // Retourne les tableaux :actCategory, actSubcategory, activity, actLocation et regAdhClass

        success: function (response) {
                console.log("ok");
            alert("Nous vous remercions pour votre inscription ! Vous recevrez prochainement toutes les dernières nouvelle du Hibou !");

        },

        error: function () {
            dataResponse = [];
            console.log("raté!");
        }

    });
}

$("#cookieClose").on("click", function(){
    $(".cookie").remove();
});