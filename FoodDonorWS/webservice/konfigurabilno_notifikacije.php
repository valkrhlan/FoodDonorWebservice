<?php

include_once("../klase/baza.php");
include_once("funkcije.php");

function dohvati_obavijesti($email, $ts) {
 
    $pomDate=$ts-(60*60);
    $d = date('Y-m-d H:i:s', $pomDate);
    
    $sql = "SELECT * FROM korisnik k LEFT JOIN detalji_pravna dp ON k.id=dp.id_korisnik WHERE email='$email'";
    $rez = vrati_podatke($sql);
    $naziv = "";
    $tip = "";
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            $tip = $row["tip"];
        }

        //1 donor -> kad kreira spremi se v_kreiranja
        //2 volonter -> kad kreira spremi se v_preuzeto
        //3 potrebiti -> kad odabere spremi se v_naručeno
        
        $notifikacije = array();
        $brojac = 0;
        if ($tip == 3) {
            $sql2 = "SELECT * FROM paketi p JOIN status s ON p.status=s.id_status  LEFT JOIN detalji_pravna dp ON p.id_donor=dp.id_korisnik WHERE v_kreiranja>'$d'";
            $rez2 = vrati_podatke($sql2);
            if ($rez2->num_rows > 0) {
                while ($row2 = $rez2->fetch_assoc()) {
                    $pom_notif = array('title' => 'Novi paket', 'message' => $row2["naziv"] . " je donirao novi paket!");
                    array_push($notifikacije, $pom_notif);
                    $brojac++;
                }
            }
        }
        elseif ($tip==2) {
            $sql2 = "SELECT * FROM paketi p JOIN status s ON p.status=s.id_status  LEFT JOIN detalji_pravna dp ON p.id_potrebitog=dp.id_korisnik WHERE v_naruceno>'$d'";
            $rez2 = vrati_podatke($sql2);
            if ($rez2->num_rows > 0) {
                while ($row2 = $rez2->fetch_assoc()) {
                    //var_dump($row["hitno"]);
                    if($row2["hitno"]!=NULL){
                       $pom_notif = array('title' => 'HITNO! Prijevoz ', 'message' => $row2["naziv"] . " treba prijevoz paketa!");
                    }else{
                         $pom_notif = array('title' => 'Prijevoz ', 'message' => $row2["naziv"] . " treba prijevoz paketa!");
                    }
                    array_push($notifikacije, $pom_notif);
                    $brojac++;
                }
            }    
        }
        elseif ($tip==1) {
            $sql2 = "SELECT * FROM paketi p JOIN status s ON p.status=s.id_status LEFT JOIN korisnik k ON p.id_volonter=k.id WHERE id_donor !=id_volonter AND v_preuzeto>'$d'";
            $rez2 = vrati_podatke($sql2);
            if ($rez2->num_rows > 0) {
                while ($row2 = $rez2->fetch_assoc()) {
                    $pom_notif = array('title' => 'Prijevoz', 'message' => $row2["ime"]." ".$row2["prezime"] . " će prevesti Vaš paket!");
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
