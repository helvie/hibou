

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Récupération d'un paramètre dans l'URL ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


jQuery(function () {

    jQuery(document).ready(function () {



        $(".commentResponseUpdate").on("click", function(){
            commentResponseId = $(this).attr("id").substr(2);
            commentId = $(this).parent().parent().attr("id").substr(3);
            // console.log("commentresponse "+commentResponseId+"commentid"+commentId);
            commentResponseUpdate(commentResponseId, commentId)
        });

        $(".commentResponseTrash").on("click", function(){
            commentResponseId = $(this).attr("id").substr(2);
            commentId = $(this).parent().parent().attr("id").substr(3);
            commentResponseTrash(commentResponseId, commentId, $(this).parent())

        });


        // console.log($commentId);        });

        $(".commentUpdate").on("click", function(){
            commentId = $(this).attr("id").substr(2);
            articleId = $(this).parent().parent().parent().attr("id").substr(3);
            commentUpdate(commentId, articleId)

        });

        $(".commentTrash").on("click", function(){
            commentId = $(this).attr("id").substr(2,3);
            articleId = $(this).parent().parent().parent().attr("id").substr(3);
            commentTrash(commentId, articleId, $(this).parent())

        })

        $(".articleTrash").on("click", function(){
            articleId = $(this).attr("id").substr(2);
            console.log(articleId);
            articleTrash(articleId, $(this).parent().parent());

        });


    });

});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function commentResponseTrash(commentResponseId, commentId, thisElt){

    jQuery.ajax({
        url: "/commentResponseTrash",
        type: "POST",
        data:
            {
                'commentResponseId' : commentResponseId,
                'commentId' : commentId
            },
        dataType: 'json',

        // Retourne les tableaux catégories, sous-catégories et activités


        success: function(response){

                thisElt.remove();
                alert("Le commentaire a bien été supprimé");

            },

        error: function(){
            dataResponse = [];
            console.log("dynamicMenu raté!");
        }

    });
}


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function commentTrash(commentId, articleId, thisElt){

    jQuery.ajax({
        url: "/commentTrash",
        type: "POST",
        data:
            {
                'articleId' : articleId,
                'commentId' : commentId
            },
        dataType: 'json',

        // Retourne les tableaux catégories, sous-catégories et activités


        success: function(response){

            thisElt.remove();
            alert("Le commentaire a bien été supprimé");

        },

        error: function(){
            dataResponse = [];
            console.log("dynamicMenu raté!");
        }

    });
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


function articleTrash(articleId, thisElt){

    console.log("gerard")

    jQuery.ajax({
        url: "/articleTrash",
        type: "POST",
        data:
            {
                'articleId' : articleId,
            },
        dataType: 'json',

        // Retourne les tableaux catégories, sous-catégories et activités


        success: function(response){

            thisElt.remove();
            alert("L'article a bien été supprimé");

        },

        error: function(){
            dataResponse = [];
            console.log("dynamicMenu raté!");
        }

    });
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
