
(function($)
{window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';
fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));
var $mcj = jQuery.noConflict(true);


$("#falseButton").on("click",function(){
    nameNL = $("#mce-FNAME").val();
    mailNL = $("#mce-EMAIL").val();
    owlPropectNLRegistred(nameNL, mailNL);
    $("#mc-embedded-subscribe").trigger("click");

});



function owlPropectNLRegistred(nameNL, mailNL) {
    console.log(nameNL +" - "+ mailNL)
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

            console.log(response);
        },

        error: function () {
            dataResponse = [];
            console.log("raté!");
        }

    });
}