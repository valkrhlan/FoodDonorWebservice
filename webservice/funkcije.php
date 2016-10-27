<?php

include_once("../klase/baza.php");

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
