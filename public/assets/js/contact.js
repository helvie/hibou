mapDisplay();


var nextDate = "";


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~ Remplissage du champ nom caché du prospect avec le nom de la société ~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


$("#prospect_information_company").on("blur", function() {
    console.log("perte focus");
    $("#prospect_information_prospect_name").val($("#prospect_information_company").val());
});


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Fonction d'ajout de jours à une date ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Date.prototype.addDays = function(days) {
    this.setDate(this.getDate() + parseInt(days));
    return this;
};

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Définition du tableau des numéros de mois
var tableMois = new Array(1,2,3,4,5,6,7,8,9,10,11,12);

// Définition du champs dernière action à "Rendez-vous téléphonique demandé"
$("#prospect_lastAction").val(12);

// Menu déroulant "heures" caché
$(".hoursMenu").hide();

//Initialisation des variables du jour et de l'heure actuelle
var nextDate = new Date();
var day = nextDate.getDay();
var hour = nextDate.getHours();

// Au clic sur une case d'option de contact
$(".contactChoice").on("click", function(){

    // Si demande de mail, menu déroulant "jour" caché
    if($("#contactChoiceMail").prop('checked')) {
        $(".daysMenu").hide();
    }
    // Si demande de contact téléphonique, menu "jour" affiché
    else if($("#contactChoiceTel").prop('checked')) {
        $(".daysMenu").show();
    }
});


// A la validation
$(".validContactForm").on("click", function(){

    // Si la demande de mail est sélectionnée
    if($("#contactChoiceMail").prop('checked')) {

        $("select.daysMenu").attr("required", false);
        $("select.hoursMenu").attr("required", false);


        // Dernière action à "infos demandées"
        numLastAction = 11;

        // Prochaine action à "envoyer un mail"
        numNextAction = 6;

    }

    // Si demande de contact par tél
    else if($("#contactChoiceTel").prop('checked')){

        $("select.daysMenu").attr("required", true);
        $("select.hoursMenu").attr("required", true);


        // Dernière action à "rendez-vous téléphonique demandé"
        numLastAction = 12;

        // Prochaine action = horaire demandé dans le menu déroulant
        numNextAction = $("#formControlSelect2").val();

        // Si l'on a bien sélectionné un jour ou que l'on est dimanche, on définit la variable de la date à laquelle on
        // doit rappeler la personne
        if($(".daysMenu").val() != 0 || day == 0) {

            // Le nombre à ajouter = la valeur de la date choisie
            daysAdd = $(".daysMenu").val();

            // Date suivante = aujourd'hui + valeur du jour selectionné
            nextDate.addDays(daysAdd);

            console.log(nextDate);
        }

    }

    // remplissage des champs avec les variables définies
    $("#prospect_lastAction").val(numLastAction);
    $("#prospect_nextAction").val(numNextAction);
    $("#prospect_nextActionDate_month").val(tableMois[nextDate.getMonth()]);
    $("#prospect_nextActionDate_year").val(nextDate.getFullYear());
    $("#prospect_nextActionDate_day").val(nextDate.getDate());

    // Le bouton déclence la validation du formulaire symfony
    $(".btnContactSave").trigger("click");

});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Gestion des menus déroulant de demande de contact ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Au changement dans le menu jours

$(".daysMenu").on("change", function() {

    // Le menu heure s'affiche
    $(".hoursMenu").show();

    // console.log("days menu "+$(".daysMenu").val());

    // Si nous ne sommes pas dimanche et qu'un jour est choisi

    // Si on est après 8h, ne pas proposer "entre 8h et 10h", si on est après 10h", ne pas proposer "entre 10h et 14h"
    if($(".daysMenu").val() == 0 && day != 0) {

        if (hour > 8) {$("#hour8").hide();}
        if (hour > 10) {$("#hour10").hide();}

    }

});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Affichage de la carte ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function mapDisplay() {


    var mymap = L.map('my_osm_widget_map', { /* use the same name as your <div id=""> */
        center: [48.8713722, 2.301316199999974], /* set GPS Coordinates */
        zoom: 17, /* define the zoom level */
        zoomControl: false, /* false = no zoom control buttons displayed */
        scrollWheelZoom: false /* false = scrolling zoom on the map is locked */
    });

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaGVsdmllIiwiYSI6ImNqbHE3dmswNzBpeG4zcHJtcDlsYzlsam0ifQ.ZhDZxIiUHk0Kg61GjvU1Jw', { /* set your personal MapBox Access Token */
        maxZoom: 20, /* zoom limit of the map */
        // attribution: 'Données &copy; Contributeurs <a href="http://openstreetmap.org">OpenStreetMap</a> + ' +
        //     '<a href="http://mapbox.com">Mapbox</a> | ' +
        //     '<a href="https://creativecommons.org/licenses/by/2.0/">CC-BY</a> ' +
        //     'Guillaume Rouan 2016', /* set the map's caption */
        id: 'mapbox.streets' /* mapbox.light / dark / streets / outdoors / satellite */
    }).addTo(mymap);

    L.marker([48.8713722, 2.301316199999974]).addTo(mymap); /* set your location's GPS Coordinates : [LAT,LON] */

}

