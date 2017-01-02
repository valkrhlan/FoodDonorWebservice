<?php

include_once("../klase/baza.php");
include_once("funkcije.php");

function dohvati_obavijesti($email, $ts) {

    $d = date('Y-m-d H:i:s', $ts);
    $sql = "SELECT * FROM korisnik k LEFT JOIN detalji_pravna dp ON k.id=dp.id_korisnik WHERE email='$email'";
    $rez = vrati_podatke($sql);
    $naziv = "";
    $tip = "";
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $tip = $row["tip"];
        }

        //1 donor
        //2 volonter
        //3 potrebiti
        $notifikacije = array();
        $brojac = 0;
        if ($tip == 3) {
            $sql2 = "SELECT * FROM paketi p JOIN status s ON p.status=s.id_status  LEFT JOIN detalji_pravna dp ON p.id_donor=dp.id_korisnik WHERE p.id_potrebitog IS NULL AND v_kreiranja>'$d'";
            $rez2 = vrati_podatke($sql2);
            if ($rez2->num_rows > 0) {
                while ($row2 = $rez2->fetch_assoc()) {
                    $pom_notif = array('title' => 'Novi paket', 'message' => $row2["naziv"] . " je donirao novi paket!");
                    array_push($notifikacije, $pom_notif);
                    $brojac++;
                }
            }
        }
        if ($brojac == 0) {
            deliver_response("OK", $brojac, "Nema ni jedne nove obavijesti!", array('notifikacije' => 'nema'));
        } else {
            deliver_response("OK", $brojac, "Ima novih notifikacija!", $notifikacije);
        }
    } else {
        deliver_response("NOT OK", 0, "Greška pri spajanju na bazu!", array('notifikacije' => 'error'));
    }//else error na bazi
}
