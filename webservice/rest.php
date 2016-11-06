<?php

//putanja http://localhost/fooddonorwebservice/FoodDonorWebservice/php/rest.php
include_once( 'funkcije.php');
header("Content-Type:application/json");

//echo "rest.php";
if (isset($_GET)) {
    if (!empty($_GET["view"])) {
        if ($_GET["view"] == 'svi_gradovi') {
            sviGradovi();
        }
    }
    if (!empty($_GET["metoda"])) {
        if ($_GET["metoda"] == 'prijava') {
            prijava($_GET["email"], $_GET["lozinka"]);
        }
        if ($_GET["metoda"] == 'registracijaOstali') {
            // var_dump($_GET);
            regOstali($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $_GET["naziv"], $_GET["tip"]);
        }
        if ($_GET["metoda"] == 'registracijaVolontera') {
            regVolontera($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $_GET["ime"], $_GET["prezime"]);
        }
    }
}


 


//RewriteRule ^registracija/fizicka/([a-zA-Z]+)/([a-zA-Z]+)/([^]]+) rest.php?ime=$1&prezime=$2&email=$3 [nc,qsa]