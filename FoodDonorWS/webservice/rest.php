<?php

//putanja http://localhost/fooddonorwebservice/FoodDonorWebservice/php/rest.php
include_once( 'funkcije.php');
include_once( 'firebase.php');
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
      //  var_dump($_GET);
        if ($_GET["metoda"] == 'prijava') {
            prijava($_GET["email"], $_GET["lozinka"]);
        }
        if ($_GET["metoda"] == 'registracijaOstali') {         
                 
            $nazivi= explode("_",$_GET["naziv"]);
            regOstali($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $nazivi[0], $_GET["tip"],$nazivi[1],$nazivi[2]);
        }
        if ($_GET["metoda"] == 'registracijaVolontera') {
            regVolontera($_GET["email"], $_GET["lozinka"], $_GET["oib"], $_GET["grad"], $_GET["adresa"], $_GET["kontakt"], $_GET["ime"], $_GET["prezime"]);
        }
        if($_GET["metoda"] == 'novi') {
            $korisnik=$_GET["korisnik"];
            $json=$_GET["json"];
            //json decode treba još napraviti;
            
           dodajNoviPaket($korisnik,$json);
           
        }
        if($_GET["metoda"] == 'dohvati') {
            $korisnik=$_GET["korisnik"];
           
           dohvatiPakete($korisnik);
           
        }
       /* if($_GET["metoda"] == 'registerDevice') {
            $email=$_GET["email"];
           $token=$_GET["token"];
           registerDevice($email,$token);
           echo "registerDevice";
        }*/
    }
}

