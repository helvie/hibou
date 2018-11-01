var currentComment;

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



        $(".commentResponseTrash").on("click", function(){
            commentResponseId = $(this).attr("id").substr(2);
            commentId = $(this).parent().parent().attr("id").substr(3);
            commentResponseTrash(commentResponseId, commentId, $(this).parent())

        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


        $(".commentUpdate").on("click", function(){

            $(".divUpdate").remove();
            $(".commentText").show();

            commentId = $(this).attr("id");
            thisCommentText = $(this).siblings(".commentText");
            createForm(thisCommentText, "comment", commentId);

            currentComment = thisCommentText;


        });


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


        $(".commentResponseUpdate").on("click", function(){

            $(".divUpdate").remove();
            $(".commentText").show();

            commentId = $(this).attr("id");
            thisCommentText = $(this).siblings(".commentText");
            createForm(thisCommentText, "commentResponse", commentId);

        });


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $(".articleAdmin").on("click", "#returnUpdate", function(){
            $(".divUpdate").remove();
            thisCommentText.show();
        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $(".articleAdmin").on("click", ".validUpdate", function(){

            if($(this).hasClass("comment")){

                thisCommentType = "comment";}

                else if($(this).hasClass("commentResponse")){

                    thisCommentType = "commentResponse";}

                commentId = $(this).attr("id").substr(2);
                console.log(commentId+" "+thisCommentType);

                commentUpdate(commentId, thisCommentType, $("#commentInput").val());
                console.log($("#commentInput").val());


        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

            $(".commentTrash").on("click", function(){
            commentId = $(this).attr("id").substr(2,3);
            articleId = $(this).parent().parent().parent().attr("id").substr(3);
            commentTrash(commentId, articleId, $(this).parent())

        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        $(".articleTrash").on("click", function(){
            articleId = $(this).attr("id").substr(2);
            console.log(articleId);
            articleTrash(articleId, $(this).parent().parent());

        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


        $(".commentVisibility").on("click", function() {
            commentId = $(this).attr("id").substr(2);
            console.log(commentId);
            commentVisibility(commentId, "comment", $(this));

        });

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


        $(".commentResponseVisibility").on("click", function() {
            commentId = $(this).attr("id").substr(2);
            console.log(commentId);
            commentVisibility(commentId, "commentResponse", $(this));
        });



    });

});


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function createForm(thisCommentText, commentType, commentId){

    formUpdate = document.createElement("div");
    formUpdate.setAttribute("class", "divUpdate");

    formUpdate.setAttribute("id", commentId);

    inputUpdate = document.createElement("input");
    inputUpdate.setAttribute('value', thisCommentText.text());
    inputUpdate.setAttribute('id', "commentInput");

    validUpdate = document.createElement('button');
    validUpdate.setAttribute("class", "validUpdate "+commentType);
    validUpdate.setAttribute("id", commentId);
    validUpdateText = document.createTextNode("Valider");
    validUpdate.appendChild(validUpdateText);

    returnUpdate = document.createElement('button');
    returnUpdate.setAttribute("id", "returnUpdate");
    returnUpdateText =document.createTextNode("Annuler");
    returnUpdate.appendChild(returnUpdateText);

    formUpdate.appendChild(inputUpdate);
    formUpdate.appendChild(validUpdate);
    formUpdate.appendChild(returnUpdate);

    thisCommentText.hide();
    thisCommentText.after(formUpdate);

}



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

    console.log("gerard");

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
};

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~




// function articleUpdate(articleId){
//
//     console.log("géraldine");
//
//     jQuery.ajax({
//         url: "/articleFormDisplay",
//         type: "POST",
//         data:
//             {
//                 'articleId' : articleId,
//             },
//         dataType: 'json',
//
//         // Retourne les tableaux catégories, sous-catégories et activités
//
//
//         success: function(response){
//
//             thisElt.remove();
//             alert("L'article a bien été supprimé");
//
//         },
//
//         error: function(){
//             dataResponse = [];
//             console.log("dynamicMenu raté!");
//         }
//
//     });
// };

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~




function commentVisibility(commentId, commentType, thisElt){

    jQuery.ajax({
        url: "/commentVisibility",
        type: "POST",
        data:
            {
                'commentId' : commentId,
                'commentType' : commentType
            },
        dataType: 'json',

        // Retourne les tableaux catégories, sous-catégories et activités


        success: function(response){

            thisElt.toggleClass("glyphicon-eye-close"),
                thisElt.toggleClass("glyphicon-eye-open");

        },

        error: function(){

            dataResponse = [];
            console.log("dynamicMenu raté!");
        }

    });
};


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


function commentUpdate(commentId, commentType, thisText){

    jQuery.ajax({
        url: "/commentUpdate",
        type: "POST",
        data:
            {
                'commentId' : commentId,
                'commentType' : commentType,
                'text' : thisText
            },
        dataType: 'json',

        // Retourne les tableaux catégories, sous-catégories et activités


        success: function(response){

            $(".divUpdate").remove();
            currentComment.text(thisText);
            currentComment.show();

        },

        error: function(){

            dataResponse = [];
            console.log("dynamicMenu raté!");
        }

    });
};