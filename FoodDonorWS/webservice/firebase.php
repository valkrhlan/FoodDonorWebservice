<?php

include_once("../klase/baza.php");
include_once("funkcije.php");
if (isset($_GET)) {
    if (!empty($_GET["metoda"])) {

        if ($_GET["metoda"] == 'registerDevice') {
            $email = $_GET["email"];
            $token = $_GET["token"];
            registerDevice($email, $token);
            //echo "registerDevice";
        }
    }
}

function registerDevice($email, $token) {
    $sql = "SELECT * FROM tokeni WHERE email='$email'";
    $txt = "";
    $rez = vrati_podatke($sql);
    if ($rez->num_rows > 0) {
        $txt .= "Izmijenjen token";
        $sql2="UPDATE tokeni SET token='$token' WHERE email='$email'";
        dodaj_u_bazu($sql2);
    } 
    else {
        $txt .= "Dodan token";
        $sql2="INSERT INTO tokeni (email, token) VALUES ('$email','$token')";
        dodaj_u_bazu($sql2);
    }
    deliver_response('OK', 0, $txt , array('evidentiranje'=>'provedeno'));
}
