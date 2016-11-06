<?php

include_once("../klase/baza.php");

function dodaj_u_bazu($upit) {
    $db = new baza;
    $db->spajanje();
    $sql = $upit;
    $rez = $db->izvrsiOstalo($sql);
    $db->prekiniVezu();
    //return $rez; 
}

function vrati_podatke($upit) {
    $db = new baza;
    $db->spajanje();
    $sql = $upit;
    $rez = $db->izvrsiSelect($sql);
    $db->prekiniVezu();
    return $rez;
}

function deliver_response($status, $nbr, $message, $data) {
    $response['status'] = $status;
    $response['nbResults'] = $nbr;
    $response['message'] = $message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}

function sviGradovi() {
    $sql = "SELECT * FROM gradovi1";
    $rez = vrati_podatke($sql);
    $nbr = 0;
    $gradovi = array();
    $status = "OK";
    $message = "Pronađeni su gradovi!";
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $pom = array('pbr' => $row["pbr"], 'naziv' => $row["naziv"]);
            array_push($gradovi, $pom);
            $nbr++;
        }
    } else {
        $pom = array('pbr' => "-1", 'naziv' => "");
        array_push($gradovi, $pom);
        $message = "Nema ni jednog grada u bazi!";
    }
    deliver_response($status, $nbr, $message, $gradovi);
}

function regVolontera($email, $lozinka, $oib, $grad, $adresa, $kontakt, $ime, $prezime) {
    $txt = provjeraKorisnika($email, $lozinka, $oib, $grad, $adresa, $kontakt);
    if (isset($ime)) {
        if (empty($ime)) {
            $txt.="Niste unjeli ime. \n";
        }
    } else {
        $txt.="Nedostaje parametar sa imenom. \n";
    }
    if (isset($prezime)) {
        if (empty($prezime)) {
            $txt.="Niste unjeli prezime. \n";
        }
    } else {
        $txt.="Nedostaje parametar sa prezimenom. \n";
    }

    if ($txt == "") {
        $sql = "INSERT into korisnik(email,kontakt,tip,OIB,lozinka,grad,adresa) VALUES('$email','$kontakt',2,'$oib','$lozinka','$grad', '$adresa')";
        dodaj_u_bazu($sql);
        $sql = "SELECT * FROM korisnik WHERE email='$email'";
        $rez = vrati_podatke($sql);
        echo $rez->num_rows;
        if ($rez->num_rows > 0) {
            $id=-1;
            while ($row = $rez->fetch_assoc()) {
                $id = $row["id"];
            }     
            $sql2 = "INSERT into fizicka(ime,prezime,id_korisnik) VALUES('$ime','$prezime','$id')";
            dodaj_u_bazu($sql2);
       
        } else {
            $txt.="Došlo je do pogreške pri zapisu u bazu";
        }
    }

     
    if($txt==""){
        deliver_response('OK', 0, 'Uspješna registracija', array('reg' => "OK"));
       
    }else{
       deliver_response('NOT OK', 0, $txt, array('reg' => "error"))  ; 
     
    }
   
}

function provjeraKorisnika($email, $lozinka, $oib, $grad, $adresa, $kontakt) {
    $tekst = "";
    if (isset($email)) {
        if (empty($email)) {
            $tekst.="Niste unjeli email. \n";
        } else {
             
            $sql = "SELECT * FROM korisnik WHERE email='$email'";
            $rez = vrati_podatke($sql);
            if ($rez->num_rows > 0) {
                $tekst.="Email je već zauzet. \n";
            }
        }
    } else {
        $tekst.="Nedostaje parametar sa emailom. \n";
    }
    if (isset($lozinka)) {
        if (empty($lozinka)) {
            $tekst.="Niste unjeli lozinku. \n";
        }
    } else {
        $tekst.="Nedostaje parametar sa lozinkom. \n";
    }
    if (isset($oib)) {
        if (empty($oib)) {
            $tekst.="Niste unjeli OIB. \n";
        }
    } else {
        $tekst.="Nedostaje parametar sa OIB-om. \n";
    }
    if (isset($grad)) {
        if (empty($grad)) {
            $tekst.="Niste unjeli grad. \n";
        }
    } else {
        $tekst.="Nedostaje parametar sa nazivom grada. \n";
    }
    if (isset($adresa)) {
        if (empty($adresa)) {
            $tekst.="Niste unjeli adresu. \n";
        }
    } else {
        $tekst.="Nedostaje parametar sa adresom. \n";
    }

    if (isset($kontakt)) {
        if (empty($kontakt)) {
            $tekst.="Niste unjeli kontakt informacije. \n";
        }
    } else {
        $tekst.="Nedostaje parametar sa kontakt informacijama. \n";
    }

    return $tekst;
}