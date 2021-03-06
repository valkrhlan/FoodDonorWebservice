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

    $response['data'] = json_encode($data);
    $json_response = json_encode($response);
    echo $json_response;
}

function sviGradovi() {
    $sql = "SELECT * FROM gradovi1 ORDER BY naziv";
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

function prijava($email, $lozinka) {
    $tekst = "";
    $tip = 0;
    if (isset($email)) {
        if (empty($email)) {
            $tekst .= "Niste unjeli email. \n";
        } else {
            
        }
    } else {
        $tekst .= "Nedostaje parametar sa emailom. \n";
    }
    if (isset($lozinka)) {
        if (empty($lozinka)) {
            $tekst .= "Niste unjeli lozinku. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa lozinkom. \n";
    }
    if (!empty($email) && !empty($lozinka)) {
        $sql = "SELECT * FROM korisnik WHERE email='$email'";
        $rez = vrati_podatke($sql);
        if ($rez->num_rows < 1) {
            $tekst .= "Korisnik ne postoji u bazi. \n";
        } else {
            $lozinkaBaza = "";
            while ($row = $rez->fetch_assoc()) {
                $lozinkaBaza = $row["lozinka"];
                $tip = $row["tip"];
            }
            if ($lozinka != $lozinkaBaza) {
                $tekst .= "Lozinke se ne podudaraju. /n";
            }
        }
    }
    if ($tekst == "") {
        if ($tip != 0) {
            deliver_response('OK', $tip, 'Uspješna prijava', array('prijava' => "OK"));
        } else {
            deliver_response('OK', 0, 'Došlo je do problema na webservisu.', array('prijava' => "error"));
        }
    } else {
        deliver_response('NOT OK', 0, $tekst, array('prijava' => "error"));
    }
}

function regOstali($email, $lozinka, $oib, $grad, $adresa, $kontakt, $naziv, $tip, $ime, $prezime) {
    $txt = provjeraKorisnika($email, $lozinka, $oib, $grad, $adresa, $kontakt, $ime, $prezime);
    $tip_br = "";
    if (isset($naziv)) {
        if (empty($naziv)) {
            $txt .= "Niste unjeli naziv. \n";
        }
    } else {
        $txt .= "Nedostaje parametar sa nazivom. \n";
    }
    if (isset($tip)) {
        if (empty($tip)) {
            $txt .= "Niste unjeli tip. \n";
        } else {
            if ($tip == 'donor') {
                $tip_br = 1;
            } else {
                if ($tip == 'potrebiti') {
                    $tip_br = 3;
                } else {
                    $txt .= "Tip nije dobrog formata. \n";
                }
            }
        }
    } else {
        $txt .= "Nedostaje parametar sa tip. \n";
    }

    if ($txt == "") {
        $sql = "INSERT into korisnik(email,kontakt,tip,OIB,lozinka,grad,adresa,ime,prezime) VALUES('$email','$kontakt','$tip_br','$oib','$lozinka','$grad', '$adresa','$ime','$prezime')";
        dodaj_u_bazu($sql);
        $sql = "SELECT * FROM korisnik WHERE email='$email'";
        $rez = vrati_podatke($sql);
        // echo $rez->num_rows;
        if ($rez->num_rows > 0) {
            $id = -1;
            while ($row = $rez->fetch_assoc()) {
                $id = $row["id"];
            }
            $sql2 = "INSERT into detalji_pravna(naziv,id_korisnik) VALUES('$naziv','$id')";
            dodaj_u_bazu($sql2);
        } else {
            $txt .= "Došlo je do pogreške pri zapisu u bazu";
        }
    }
    if ($txt == "") {
        deliver_response('OK', 0, 'Uspješna registracija', array('reg' => "OK"));
    } else {
        deliver_response('NOT OK', 0, $txt, array('reg' => "error"));
    }
}

function regVolontera($email, $lozinka, $oib, $grad, $adresa, $kontakt, $ime, $prezime) {
    $txt = provjeraKorisnika($email, $lozinka, $oib, $grad, $adresa, $kontakt, $ime, $prezime);

    if ($txt == "") {
        $sql = "INSERT into korisnik(email,kontakt,tip,OIB,lozinka,grad,adresa,ime,prezime) VALUES('$email','$kontakt',2,'$oib','$lozinka','$grad', '$adresa','$ime','$prezime')";
        dodaj_u_bazu($sql);
        $sql = "SELECT * FROM korisnik WHERE email='$email'";
        $rez = vrati_podatke($sql);

        if ($rez->num_rows < 1) {
            $txt .= "Došlo je do pogreške pri zapisu u bazu";
        }
    }


    if ($txt == "") {
        // array_push($data, array('reg' => "OK"));     
        deliver_response('OK', 0, 'Uspješna registracija', array('reg' => "OK"));
    } else {
        // array_push($data, array('reg' => "error"));     

        deliver_response('NOT OK', 0, $txt, array('reg' => "error"));
    }
}

function provjeraKorisnika($email, $lozinka, $oib, $grad, $adresa, $kontakt, $ime, $prezime) {
    $tekst = "";
    if (isset($email)) {
        if (empty($email)) {
            $tekst .= "Niste unjeli email. \n";
        } else {

            $sql = "SELECT * FROM korisnik WHERE email='$email'";
            $rez = vrati_podatke($sql);
            if ($rez->num_rows > 0) {
                $tekst .= "Email je već zauzet. \n";
            }
        }
    } else {
        $tekst .= "Nedostaje parametar sa emailom. \n";
    }
    if (isset($lozinka)) {
        if (empty($lozinka)) {
            $tekst .= "Niste unjeli lozinku. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa lozinkom. \n";
    }
    if (isset($oib)) {
        if (empty($oib)) {
            $tekst .= "Niste unjeli OIB. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa OIB-om. \n";
    }
    if (isset($grad)) {
        if (empty($grad)) {
            $tekst .= "Niste unjeli grad. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa nazivom grada. \n";
    }
    if (isset($adresa)) {
        if (empty($adresa)) {
            $tekst .= "Niste unjeli adresu. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa adresom. \n";
    }

    if (isset($kontakt)) {
        if (empty($kontakt)) {
            $tekst .= "Niste unjeli kontakt informacije. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa kontakt informacijama. \n";
    }

    if (isset($ime)) {
        if (empty($ime)) {
            $tekst .= "Niste unjeli ime. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa imenom. \n";
    }
    if (isset($prezime)) {
        if (empty($prezime)) {
            $tekst .= "Niste unjeli prezime. \n";
        }
    } else {
        $tekst .= "Nedostaje parametar sa prezimenom. \n";
    }

    return $tekst;
}

function dohvati_vrste_i_jedinice() {

    $nbr = 0;
    $polje = array();
    $vrsta = array();
    $jedinica = array();
    $status = "OK";
    $message = "Pronađeni su rezultati!";
    $sql = "SELECT * FROM vrsta";
    $rez = vrati_podatke($sql);
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $pom = array('id' => $row["id"], 'naziv' => $row["naziv"]);
            array_push($vrsta, $pom);
        }
    } else {
        $pom = array('id' => "-1", 'naziv' => "");
        array_push($vrsta, $pom);
        $message = "Nema zapisa u bazi!";
    }
    $sql = "SELECT * FROM jedinica";
    $rez = vrati_podatke($sql);
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $pom2 = array('id' => $row["id"], 'naziv' => $row["naziv"]);
            array_push($jedinica, $pom2);
        }
    } else {
        $pom2 = array('id' => "-1", 'naziv' => "");
        array_push($jedinica, $pom2);
        $message = "Nema zapisa u bazi!";
    }
    $polje = array('vrsta' => $vrsta, 'jedinica' => $jedinica);
    //array_push($polje, $pom3);
    deliver_response($status, $nbr, $message, $polje);
}

function dodaj_bazu_vrai_id($upit) {
    $db = new baza;
    $con = mysqli_connect("localhost", "root", "", "id156228_air_test");

    if (!$con) {
        return -1;
    } else {
        $sql = $upit;
        mysqli_query($con, $sql);
        $id = mysqli_insert_id($con);
        mysqli_close($con);
        if (empty($id))
            return -1;
        else {
            return $id;
        }
    }

    //return $rez; 
}

function dodajNoviPaket($korisnik, $json, $prijevoz) {

    $tekst = "";
    $pom = substr($json, 1, strlen($json) - 2);
    $sql = "SELECT id FROM korisnik WHERE email='$korisnik'";
    $rez = vrati_podatke($sql);
    $donor = "";
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $donor = $row["id"];
        }

        $date = date("Y-m-d H:i:s");
        if ($prijevoz == 1) {
            $sql2 = "INSERT INTO status(v_kreiranja,v_preuzeto) VALUES('$date','$date')";
        } else {
            $sql2 = "INSERT INTO status(v_kreiranja) VALUES('$date')";
        }
        $status = dodaj_bazu_vrai_id($sql2);
        if ($status == -1) {
            $tekst .= "Greška pri spajanju na bazu";
        } else {
            if ($prijevoz == 1) {
                $sql3 = "INSERT INTO paketi(status,id_donor,id_volonter,preuzimanje) values('$status','$donor','$donor','$prijevoz')";
            } else {
                $sql3 = "INSERT INTO paketi(status,id_donor,preuzimanje) values('$status','$donor','$prijevoz')";
            }
            // echo $sql3;
            $paket = dodaj_bazu_vrai_id($sql3);
            // echo $paket;
            if ($paket == -1) {
                $tekst .= "Greška pri spajanju na bazu";
            } else {
                $stavke = json_decode($json, true);

                foreach ($stavke as $stavka) {
                    $jedinica = $stavka["jedinica"]["id"];
                    $kol = $stavka["kolicina"];
                    $naz = $stavka["naziv"];
                    $vrsta = $stavka["vrsta"]["id"];

                    $sql = "INSERT INTO stavka(naziv,kolicina,jedinica,vrsta) VALUES('$naz','$kol','$jedinica','$vrsta')";
                    $stavka_id = dodaj_bazu_vrai_id($sql);
                    if ($stavka_id != -1) {
                        $sql2 = "INSERT INTO stavka_paket(id_stavka,id_paket) VALUES('$stavka_id','$paket')";
                        dodaj_u_bazu($sql2);
                    }
                }
            }
        }
        // echo $status;
    } else {
        $tekst .= "Korisnik ne postoji  bazi.";
    }
    if ($tekst == "") {

        deliver_response('OK', 0, 'Uspješno dodano!', array('dodavanje' => "OK"));
        //deliver_response('OK', 0, $pom, array('dodavanje' => "OK"));
    } else {
        // array_push($data, array('reg' => "error"));     

        deliver_response('NOT OK', 0, $tekst, array('dodavanje' => "error"));
        // deliver_response('NOT OK', 0, $tekst, array('dodavanje' => $pom));
    }
}

function dohvatiPakete($korisnik, $odabrani, $grad) {
    $txt = "";

    $sql = "SELECT id,tip FROM korisnik WHERE email='$korisnik'";
    $rez = vrati_podatke($sql);
    $popis_paketa;
    $br_paketa = 0;
    if ($rez->num_rows > 0) {
        $tip = -1;
        $id_korisnika = -1;
        while ($row = $rez->fetch_assoc()) {
            $tip = $row["tip"];
            $id_korisnika = $row["id"];
        }

        //1 donor
        //2 volonter
        //3 potrebiti
        $donoriOdredjenogGrada = array();
        if ($tip == 1) {
            $sql2 = "SELECT * FROM paketi p JOIN status s ON p.status=s.id_status JOIN korisnik k ON p.id_donor=k.id WHERE pristiglo IS NULL AND p.id_donor IS NOT NULL AND k.email='$korisnik' ";
        } elseif ($tip == 2 && $odabrani == 'ne') {
            $sql2 = "SELECT * FROM paketi p JOIN status s on p.status=s.id_status WHERE pristiglo IS NULL AND id_donor IS NOT NULL AND id_potrebitog IS NOT NULL AND  id_volonter IS NULL";
            $sql2b = "SELECT id FROM korisnik WHERE grad='$grad'";
            $rez = vrati_podatke($sql2b);
            if ($rez - num_rows > 0) {
                while ($row = $rez->fetch_assoc()) {
                    array_push($donoriOdredjenogGrada, $row["id"]);
                }
            }
        } elseif ($tip == 3 && $odabrani == 'ne') {
            $sql2 = "SELECT * FROM paketi p JOIN status s on p.status=s.id_status WHERE pristiglo IS NULL AND id_donor IS NOT NULL AND id_potrebitog IS NULL AND id_volonter IS NULL"; //id potr i id volon
        }
        //-----------------------------------------------------------
        //------------------- COKY 11.1.2017. -----------------------
        //-----------------------------------------------------------
        elseif ($tip == 3 && $odabrani == 'da') {
            $sql2 = "SELECT * FROM paketi p JOIN status s on p.status=s.id_status WHERE pristiglo IS NULL AND id_donor IS NOT NULL AND p.id_potrebitog=$id_korisnika";
        } elseif ($tip == 2 && $odabrani == 'da') {
            $sql2 = "SELECT * FROM paketi p JOIN status s on p.status=s.id_status WHERE pristiglo IS NULL AND p.id_volonter=$id_korisnika";
        }
        $rez = vrati_podatke($sql2);
        $paketi = array();
        if ($rez->num_rows > 0) {
            while ($row = $rez->fetch_array()) {
                if ($tip == 2 && $odabrani == 'ne') {
                    if (in_array($row["id_donor"], $donoriOdredjenogGrada) == FALSE) {
                        continue;
                    }
                }
                $br_paketa++;
                $id_paketa = $row[0];
                $sql3 = "SELECT s.id,s.naziv,s.kolicina,s.vrsta,v.naziv,s.jedinica,j.naziv FROM stavka s JOIN stavka_paket sp ON s.id=sp.id_stavka JOIN vrsta v on s.vrsta=v.id JOIN jedinica j ON s.jedinica=j.id WHERE sp.id_paket='$id_paketa'";
                $rez3 = vrati_podatke($sql3);
                $stavka = array();
                if ($rez3->num_rows > 0) {
                    while ($row3 = $rez3->fetch_array()) {
                        // print_r($row3);

                        $pom2 = array('id' => $row3[0], 'naziv' => $row3[1], 'kolicina' => $row3[2], 'id_vrsta' => $row3[3], 'vrsta' => $row3[4], 'id_jedinica' => $row3[5], 'jedinica' => $row3[6]);
                        array_push($stavka, $pom2);
                    }
                }
                $naziv_volontera = "";
                $naziv_donora = "";
                $naziv_potrebitog = "";

                if ($row["id_donor"] != NULL) {
                    $pomdonor = $row["id_donor"];
                    $sql4 = "SELECT naziv FROM detalji_pravna WHERE id_korisnik='$pomdonor'";
                    $rez4 = vrati_podatke($sql4);
                    if ($rez4->num_rows > 0) {
                        while ($row4 = $rez4->fetch_array()) {
                            $naziv_donora = $row4["naziv"];
                        }
                    }
                }
                if ($row["id_volonter"] != NULL) {
                    if ($row["id_volonter"] == $row["id_donor"]) {
                        $naziv_volontera = $naziv_donora;
                    } else {
                        $pomvolonter = $row["id_volonter"];
                        $sql4 = "SELECT k.ime,k.prezime,dp.naziv FROM korisnik k LEFT JOIN detalji_pravna dp ON k.id=dp.id_korisnik WHERE k.id='$pomvolonter'";
                        $rez4 = vrati_podatke($sql4);
                        if ($rez4->num_rows > 0) {
                            while ($row4 = $rez4->fetch_array()) {
                                if ($row4["naziv"] != NULL) {
                                    $naziv_volontera = $row4["naziv"];
                                } else {
                                    $naziv_volontera = $row4["ime"] . " " . $row4["prezime"];
                                }
                            }
                        }
                    }
                }
                if ($row["id_potrebitog"] != NULL) {
                    $pompotrebiti = $row["id_potrebitog"];
                    $sql4 = "SELECT naziv FROM detalji_pravna WHERE id_korisnik='$pompotrebiti'";
                    $rez4 = vrati_podatke($sql4);
                    if ($rez4->num_rows > 0) {
                        while ($row4 = $rez4->fetch_array()) {
                            $naziv_potrebitog = $row4["naziv"];
                        }
                    }
                }
                $paket = array('id' => $row["id"], 'preuzimanje' => $row["preuzimanje"], 'hitno' => $row["hitno"], 'id_volonter' => $row["id_volonter"], 'naziv_volonter' => $naziv_volontera, 'id_donor' => $row["id_donor"], 'naziv_donor' => $naziv_donora, 'id_potrebitog' => $row["id_potrebitog"], 'naziv_potrebitog' => $naziv_potrebitog, 'v_kreiranja' => $row["v_kreiranja"], 'v_naruceno' => $row["v_naruceno"], 'v_preuzeto' => $row["v_preuzeto"], 'v_slanja' => $row["v_slanja"], 'v_pristiglo' => $row["v_pristiglo"], 'stavke' => json_encode($stavka));
                array_push($paketi, $paket);
            }
        } else {
            $txt .= "Nema paketa za traženog korisnika";
        }
    } else {
        $txt .= "Korisnik ne postoji u bazi";
    }
    //print_r($paketi);

    if ($txt != "") {
        deliver_response('NOT OK', 0, $txt, array('paketi' => "error"));
    } else {
        deliver_response("OK", $br_paketa, "Uspješno dohvaćanje", $paketi);
    }
}

function odaberiPaketPotrebiti($email, $hitno, $idPaketa) {
    $date = date("Y-m-d H:i:s");
    $txt = "";
    $sql = "SELECT id FROM korisnik WHERE email='$email'";
    $rez = vrati_podatke($sql);
    $id_korisnika = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $id_korisnika = $row["id"];
    } else {
        $txt .= "Nepostojeći korisnik.";
    }
    $sql = "SELECT status FROM paketi WHERE id=$idPaketa";
    $rez = vrati_podatke($sql);
    $status = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $status = $row["status"];
    } else {
        $txt .= " Nepostojeći paket.";
    }
    if ($hitno == 'ne') {
        $sql = "UPDATE paketi SET id_potrebitog=$id_korisnika WHERE id=$idPaketa";
    } else {
        $sql = "UPDATE paketi SET id_potrebitog=$id_korisnika, hitno=1 WHERE id=$idPaketa";
    }

    dodaj_u_bazu($sql);
    $sql = "UPDATE status SET v_naruceno='$date' WHERE id_status=$status";
    dodaj_u_bazu($sql);
    if ($txt != "") {
        deliver_response('NOT OK', 0, $txt, array('odabraniPaketi' => "error"));
    } else {
        if ($hitno == 'ne') {
            deliver_response("OK", 1, "Paket odabran!", array('odabraniPaketi' => "OK"));
        } else {
            deliver_response("OK", 1, "Poslan hitan signal!", array('odabraniPaketi' => "OK"));
        }
    }
}

function odaberiPaketVolonter($email, $idPaketa) {
    $date = date("Y-m-d H:i:s");
    $txt = "";
    $sql = "SELECT id FROM korisnik WHERE email='$email'";
    $rez = vrati_podatke($sql);
    $id_korisnika = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $id_korisnika = $row["id"];
    } else {
        $txt .= "Nepostojeći korisnik.";
    }
    $sql = "SELECT status FROM paketi WHERE id=$idPaketa";
    $rez = vrati_podatke($sql);
    $status = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $status = $row["status"];
    } else {
        $txt .= " Nepostojeći paket.";
    }
    $sql = "UPDATE paketi SET id_volonter=$id_korisnika WHERE id=$idPaketa";
    dodaj_u_bazu($sql);
    $sql = "UPDATE status SET v_preuzeto='$date' WHERE id_status=$status";
    dodaj_u_bazu($sql);
    if ($txt != "") {
        deliver_response('NOT OK', 0, $txt, array('odabraniPaketi' => "error"));
    } else {
        deliver_response("OK", 1, "Paket odabran!", array('odabraniPaketi' => "OK"));
    }
}

function evidentirajDolazak($idPaketa) {
    $date = date("Y-m-d H:i:s");
    $txt = "";
    $sql = "SELECT status FROM paketi WHERE id=$idPaketa";
    $rez = vrati_podatke($sql);
    $status = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $status = $row["status"];
    } else {
        $txt .= " Nepostojeći paket.";
    }
    $sql = "UPDATE paketi SET pristiglo=1 WHERE id=$idPaketa";
    dodaj_u_bazu($sql);
    $sql = "UPDATE status SET v_pristiglo='$date' WHERE id_status=$status";
    dodaj_u_bazu($sql);
    if ($txt != "") {
        deliver_response('NOT OK', 0, $txt, array('evidentiranDolazak' => "error"));
    } else {
        deliver_response("OK", 1, "Evidentirano!", array('evidentiranDolazak' => "OK"));
    }
}

function preuzmiKoordinate($idPaketa) {
    $txt = "";
    $sql = "SELECT id_donor, id_potrebitog FROM paketi WHERE id=$idPaketa";
    $rez = vrati_podatke($sql);
    $id_donor = -1;
    $id_potrebitog = -1;
    if ($rez->num_rows > 0) {
        $row = $rez->fetch_assoc();
        $id_donor = $row["id_donor"];
        $id_potrebitog = $row["id_potrebitog"];
    } else {
        $txt .= " Nepostojeći paket.";
    }
    $sql = "SELECT adresa,grad FROM korisnik WHERE id=$id_donor";
    $rez = vrati_podatke($sql);
    $row = $rez->fetch_assoc();
    $donor_ulica = $row["adresa"];
    $donor_grad = $row["grad"];
    $donor_adresa = $donor_ulica . " " . $donor_grad;
    $sql = "SELECT adresa,grad FROM korisnik WHERE id=$id_potrebitog";
    $rez = vrati_podatke($sql);
    $row = $rez->fetch_assoc();
    $potrebiti_ulica = $row["adresa"];
    $potrebiti_grad = $row["grad"];
    $potrebiti_adresa = $potrebiti_ulica . " " . $potrebiti_grad;
    $koordinate_donor = dohvatiKoordinate($donor_adresa);
    $koordinate_potrebiti = dohvatiKoordinate($potrebiti_adresa);
    $koordinate = array('lat_donor' => $koordinate_donor[0], 'lng_donor' => $koordinate_donor[1], 'lat_potrebiti' => $koordinate_potrebiti[0], 'lng_potrebiti' => $koordinate_potrebiti[1]);
    if ($txt != "") {
        deliver_response('NOT OK', 0, $txt, array('preuzmiKoordinate' => "error"));
    } else {
        deliver_response("OK", 1, "Koordinate dohvaćene!", $koordinate);
    }
    
}

function dohvatiKoordinate($adresa){
   $adresa_uredjena = str_replace (" ", "+", $adresa);
   $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $adresa_uredjena . "&sensor=false";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $geoloc = json_decode(curl_exec($ch), true);
   $koordinate = array();
   array_push($koordinate, $geoloc['results'][0]['geometry']['location']['lat']);
   array_push($koordinate, $geoloc['results'][0]['geometry']['location']['lng']);
   return $koordinate;
}
