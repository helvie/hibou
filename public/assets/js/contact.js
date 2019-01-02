mapDisplay();


var nextDate = "";

//--------------------------------------------------------------------------------------------------------

$("#prospect_information_company").on("blur", function() {
    console.log("perte focus");
    $("#prospect_information_prospect_name").val($("#prospect_information_company").val());
});

//---------------------------------------------------------------------------------------------------------


Date.prototype.addDays = function(days) {
    this.setDate(this.getDate() + parseInt(days));
    return this;
};

//---------------------------------------------------------------------------------------------------------

var tableMois = new Array(1,2,3,4,5,6,7,8,9,10,11,12);

$("#prospect_lastAction").val(12);

$(".hoursMenu").hide();

var nextDate = new Date();
var day = nextDate.getDay();
var hour = nextDate.getHours();


$(".contactChoice").on("click", function(){

    if($("#contactChoiceMail").prop('checked')) {
        $(".daysMenu").hide();
    }
    else if($("#contactChoiceTel").prop('checked')) {
        $(".daysMenu").show();
    }
});



$(".validContactForm").on("click", function(){

    if($("#contactChoiceMail").prop('checked')) {




        numLastAction = 11;
        numNextAction = 6;

        console.log(nextDate);

    }

    else if($("#contactChoiceTel").prop('checked')){


        numLastAction = 12;
        numNextAction = $("#formControlSelect2").val();

        if($(".daysMenu").val() != 0 || day == 0) {

            daysAdd = $(".daysMenu").val();
            nextDate.addDays(daysAdd);

            console.log(nextDate);
        }

    }

    $("#prospect_lastAction").val(numLastAction);
    $("#prospect_nextAction").val(numNextAction);
    $("#prospect_nextActionDate_month").val(tableMois[nextDate.getMonth()]);
    $("#prospect_nextActionDate_year").val(nextDate.getFullYear());
    $("#prospect_nextActionDate_day").val(nextDate.getDate());

    $(".btnContactSave").trigger("click");

});


$(".daysMenu").on("change", function() {

    $(".hoursMenu").show();

    console.log("days menu "+$(".daysMenu").val());

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

