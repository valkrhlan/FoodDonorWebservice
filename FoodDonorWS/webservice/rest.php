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
         if ($_GET["view"] == 'vrsta_jedinica') {
            dohvati_vrste_i_jedinice();
        }
    }
    if (!empty($_GET["metoda"])) {
         var_dump($_GET);
        if ($_GET["metoda"] == 'prijava') {
            prijava($_GET["email"], $_GET["lozinka"]);
        }
        if ($_GET["metoda"] == 'registracijaOstali') {          
            regOstali($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $_GET["naziv"], $_GET["tip"]);
        }
        if ($_GET["metoda"] == 'registracijaVolontera') {
            regVolontera($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $_GET["ime"], $_GET["prezime"]);
        }
        if($_GET["metoda"] == 'novi') {
            echo "tu sam";
            //$json=$_GET["json"];
            print_r($_GET);
           // echo($json);
           // print_r(json_decode($json));
        }
    }
}


 


//RewriteRule ^registracija/fizicka/([a-zA-Z]+)/([a-zA-Z]+)/([^]]+) rest.php?ime=$1&prezime=$2&email=$3 [nc,qsa]