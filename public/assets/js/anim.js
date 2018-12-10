//
// var canvas = document.getElementById("canvas");
// var context1 = canvas.getContext("2d");
// var context2 = canvas.getContext("2d");
// var context3 = canvas.getContext("2d");
// var context4 = canvas.getContext("2d");
//
//
//
// // context.beginPath();
// // context.lineTo(300, 200); // ligne importante pour créer un quart de cercle
// // context.arc(300, 200, 50, 180*(Math.PI/180), 270*(Math.PI/180), false);
// // context.closePath()
// // context.fill();
//
// // haut droit
// context1.beginPath();
// context1.lineTo(300, 200);
// context1.arc(300, 200, 50, 270*(Math.PI/180), 0, false);
// context1.closePath();
// context1.fill();
// context1.fillStyle="#ff0000";
//
// // bas gauche
// context2.beginPath();
// context2.lineTo(300, 200);
// context2.arc(300, 200, 50, 90*(Math.PI/180), 180*(Math.PI/180), false);
// context2.closePath();
// context2.fill();
//
// // bas droite
// context3.beginPath();
// context3.lineTo(300, 200);
// context3.arc(300, 200, 50, 0, 90*(Math.PI/180), false);
// context3.closePath();
// context3.fill();
//
// context4.beginPath();
// context4.lineTo(300, 200); // ligne importante pour créer un quart de cercle
// context4.arc(300, 200, 50, 180*(Math.PI/180), 270*(Math.PI/180), false);
// context4.closePath()
// context4.fill();
//
// var redCircle1a = document.getElementById('context1');
//
//
// (function(){
//
//     var canvas = document.getElementById('canvas');
//     var context = canvas.getContext('2d');
//     var cube = {x:50, y:100};
//
//     function boucle(){
//
//
//
//         // ctx.clearRect(0,0, 500,500);
//
//
//
//         //
//         // // dessine le cube à sa position
//         // ctx.fillStyle = 'black';
//         // ctx.fillRect(cube.x, cube.y, 20, 20);
//
//         // déplace le cube et boucle tant qu'il est pas arrivé
//         if(!moveObject(cube, {x:300,y:250}, 2))
//             setTimeout(boucle, 1000/60);
//     }
//
//     boucle();
//
// // a: actuel {x, y}; n: arrivé {x, y}; v vitesse pixel
//     function moveObject(ac, ne, v){
//         var   s = {x:1, y:1}		// sens
//             , move = {x:1, y:1}		// pixel de déplacement
//             , delta = 0				// delta -> pythagore
//             , dist = {}				// distance entre start et end
//         ;
//
//         // distance x/y
//         dist.x = Math.abs(ac.x-ne.x);
//         dist.y = Math.abs(ac.y-ne.y);
//
//         // racine carré de A² + B² (pythagore) -> donne l'hypoténuse
//         delta = Math.sqrt((dist.x*dist.x)+(dist.y*dist.y));
//
//         // règle des tiers afin d'avoir le déplacement par rapport à V et Delta
//         move.x = (dist.x*v)/delta;
//         move.y = (dist.y*v)/delta;
//
//         // déplacement vers la gauche -1, droite 1, haut -1, bas 1
//         s.x = (ac.x > ne.x)? -1: 1;
//         s.y = (ac.y > ne.y)? -1: 1;
//
//         // rajoute à nos coordonnées actuel le déplacement dans le bon sens
//         ac.x += move.x*s.x;
//         ac.y += move.y*s.y;
//
//         // retourne si l'objet est arrivé à son objectif -Vpx=marge d'erreur-
//         return (dist.x <= v && dist.y <= v)? true: false;
//     };
//
// })();

// var canvas = document.getElementById('canvas');
// var context = canvas.getContext('2d');
//
// var redCircle1a = {
//     x: 100,
//     y: 100,
//     radius: 25,
//     color: 'blue',
//     draw: function() {
//         context.fillStyle="#000000";
//         context.beginPath();
//         context.lineTo(300, 200);
//         context.arc(300, 200, 50, 270*(Math.PI/180), 0, false);
//         context.closePath();
//         context.fill();
//     }
// };
//
// var redCircle1b = {
//     x: 100,
//     y: 100,
//     radius: 25,
//     color: 'blue',
//     draw: function() {
//         context.fillStyle="#ff0000";
//         context.beginPath();
//         context.lineTo(300, 200);
//         context.arc(300, 200, 50, 90*(Math.PI/180), 180*(Math.PI/180), false);
//         context.closePath();
//         context.fill();
//     }
// };var redCircle1c = {
//     x: 100,
//     y: 100,
//     radius: 25,
//     color: 'blue',
//     draw: function() {
//         context.fillStyle="#00ff00";
//         context.beginPath();
//         context.lineTo(300, 200);
//         context.arc(300, 200, 50, 0, 90*(Math.PI/180), false);
//         context.closePath();
//         context.fill();
//     }
// };var redCircle1d = {
//     x: 100,
//     y: 100,
//     radius: 25,
//     color: 'blue',
//     draw: function() {
//         context.fillStyle="#0000ff";
//         context.beginPath();
//         context.lineTo(280, 200); // ligne importante pour créer un quart de cercle
//         context.arc(280, 200, 50, 180*(Math.PI/180), 270*(Math.PI/180), false);
//         context.closePath();
//         context.fill();
//     }
// };
//
// redCircle1a.draw();
// redCircle1b.draw();
// redCircle1c.draw();
// redCircle1d.draw();

//----------------------------------------------------------------------------------------------------------------------
//---------------------------------------- Menu ---------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
$(document).ready(function ($) {
    //your code here

$('.hamburger').click(function() {
    $('.owlMenu').toggleClass('active');
    $('.hamburger').toggleClass('hamburger-active');
});

// $('.speBlock2').hide();


//----------------------------------------------------------------------------------------------------------------------
//--------------------------------------------- Détail savoir faire ----------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------


$('.markOpen').click(function(){
    console.log('essai');
    $('.market').toggleClass("speDisplay");
    $('.markImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');

});

$('.market').click(function(){
    $('.market').toggleClass("speDisplay");
    $('.markImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');
});

$('.devOpen').click(function(){
    console.log('essai');
    $('.dev').toggleClass("speDisplay");
    $('.devImg').toggleClass('speImgDisplay');
    $('.generalSpeBlock').toggleClass('hide');

});

$('.devClose').click(function(){
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

});
//--------------------------------------------

$("#form1").click(function() {
    $("#form2").toggleClass("index");
    console.log("form 1");
});

$("#form2").click(function() {
    $("#form1").toggleClass("index");
    console.log("form 2");

});