<?php

//putanja http://localhost/fooddonorwebservice/FoodDonorWebservice/php/rest.php
include_once( 'funkcije.php');
include_once( 'firebase.php');
include_once ('konfigurabilno_notifikacije.php');
header("Content-Type:application/json");

//echo "rest.php";
if (isset($_GET)) {
    //print_r($_GET);
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
            $prijevoz=$_GET["prijevoz"];
            dodajNoviPaket($korisnik,$json,$prijevoz);
           
        }
        if($_GET["metoda"] == 'dohvati') {
            $korisnik=$_GET["korisnik"];
            $odabrani=$_GET["odabrani"];
           dohvatiPakete($korisnik, $odabrani);
           
        }
       if($_GET["metoda"] == 'getNotifications') {
            $email=$_GET["email"];
            $ts=$_GET["timestamp"];
            dohvati_obavijesti($email,$ts);
            
        }
       
        if($_GET["metoda"] == 'odaberiPaketPotrebiti') {
            $email=$_GET["email"];
            $hitno=$_GET["hitno"];
            $idPaketa=$_GET["idPaketa"];
            odaberiPaketPotrebiti($email,$hitno,$idPaketa);
            
        }
        
        if($_GET["metoda"] == 'odaberiPaketVolonter') {
            $email=$_GET["email"];
            $idPaketa=$_GET["idPaketa"];
            odaberiPaketVolonter($email,$idPaketa);
        }
        
        if($_GET["metoda"] == 'evidentirajDolazak'){
            $idPaketa=$_GET["idPaketa"];
            evidentirajDolazak($idPaketa);
        }
    }
}

