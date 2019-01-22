

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Menu ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$(document).ready(function($) {


// Au clic sur le menu, changement de classe "déplié" ou "replié"

$('.hamburger').click(function() {
    $('.owlMenu').toggleClass('active');
    $('.hamburger').toggleClass('hamburger-active');
});



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Détail savoir faire ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


// Au clic sur une spécialisation, changement de class pour anim en CSS




$('.markOpen').click(function(){
    console.log('essai');
    $('.generalSpeBlock').toggleClass('hide');

    $('.market').toggleClass("speDisplay");
    $('.markImg').toggleClass('speImgDisplay');
    // $('.market').show();
    // $(".callSpe").hide();
    // $('.specialization').css('padding-bottom',0);



});

$('.market').click(function(){
    $('.market').hide();
    $('.market').toggleClass("speDisplay");
    $('.markImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');
    $('.market').show();

    // $('.specialization').toggleClass('specialization2');

});

$('.devOpen').click(function(){
    console.log('essai');
    $('.dev').toggleClass("speDisplay");
    $('.devImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');

});

$('.dev').click(function(){
    $('.dev').toggleClass("speDisplay");
    $('.devImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');
});

$('.designOpen').click(function(){
    console.log('essai');
    $('.design').toggleClass("speDisplay");
    $('.designImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');

});

$('.design').click(function(){
    $('.design').toggleClass("speDisplay");
    $('.designImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');
});

$('.auditOpen').click(function(){
    console.log('essai');
    $('.audit').toggleClass("speDisplay");
    $('.auditImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');

});

$('.audit').click(function(){
    $('.audit').toggleClass("speDisplay");
    $('.auditImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');
});



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


$("#form1").click(function() {
    $("#form2").toggleClass("index");
    console.log("form 1");
});

$("#form2").click(function() {
    $("#form1").toggleClass("index");
    console.log("form 2");

});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  Animation jeu de cartes ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Le tri aléatoire des cartes se font au niveau du contrôleur

var cardId1 = "";
var cardId2 = "";
var diffCard = "";
var thisCard = "";


// Au clic sur une carte

$(".gameCard").on("click", function(){

    // Si deux cartes était déjà retournées mais différentes

    if(diffCard == 1){

        // On enlève la classe "retournée" sur les cartes précédemment retournées

        $(".flipped").removeClass("flipped")
    }

    // On remet la variable de cartes retournées à 0
    diffCard = 0;

    // On ajoute la classe "retournée" à la carte que l'on vient de cliquer

    $(this).addClass("flipped");

    // Si la variable carte 1 est vide, aucune carte n'est encore retournée

    if(cardId1==""){

        // On lui attribue l'Id du présent élément
        cardId1 = $(this).parent().attr("id").substr(1)
    }

    // Sinon, on attribue l'Id du présent élément à la carte 2

    else
    {
        cardId2 = $(this).parent().attr("id").substr(1)
    }

    // Si les variables de cartes 1 et 2 sont toutes 2 remplies, 2 cartes sont retournées

    if(cardId1 != "" && cardId2 != ""){
        console.log("jeu complet");

        // Si l'Id de la carte 1 = l'Id de la carte 2

        if(cardId1 == cardId2){

            // On enlève la classe "retournée" et on ajoute la classe "retournée définitivement"

            $(".flipped").removeClass("flipped").addClass("flippedOk");

            // Affichage du texte selon les cartes identiques qui ont été retournées

            if(cardId1 == "red"){
                $("#cardText").text('"SEO" est l\'acronyme de "Search Engine Optimization" et peut être défini comme l\'art de positionner un site, une page web ou une application dans les premiers résultats naturels des moteurs de recherche.')
            }
            if(cardId1 == "blue") {
                $("#cardText").text('Le "ROI", Return On Investment" en anglais, correspond à un indicateur qui indique si une opération marketing à été une réussie ou non en termes de revenu financier. Plus simplement, c\'est l\'argent gagné par rapport à l\'argent investi.')

            }
            if(cardId1 == "green") {
                $("#cardText").text('Le CTA ou “call to action” est une incitation à l’action sur votre page web ou votre site internet, présentée sous forme d’un bouton ou bien d’une bannière généralement visible et coloré, proposant à l’internaute de faire une action')

            }
            if(cardId1 == "pink") {
                $("#cardText").text('Le terme "UX" vient de l\'anglais "User experience" et représente le ressenti émotionnel d\'un utilisateur face à une interface, un objet ou un service.')

            }
            if(cardId1 == "yellow"){
                $("#cardText").text('"LHQG" C\'est une agence dynamique et créative qui saura donner vie à tous vos projets. C\'est l\'agence spécialiste de l\'accessibilité')


            }
            if(cardId1 == "orange") {
                $("#cardText").text('Le « W3C » est un sigle utilisé pour définir le « World Wide Web Consortium » qui est une organisation non lucrative permettant définir des standards pour les technologies liées aux web. Du point de vue européen, les standards fournis par cet organisme ne sont que des recommandations et non des normes standardisés. Cela permet de guider les technologies du web dans une même direction sur le long terme et ainsi améliorer leur compatibilité.')

            }

        }

        // Si les 2 cartes ont été retournées mais qu'elles ne sont pas identiques, mise de la variable "cartes différentes"
        // à 1
        else {
            diffCard=1;
        }
        cardId1="";
        cardId2="";
    }

});



});