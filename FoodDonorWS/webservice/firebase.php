<?php

include_once("../klase/baza.php");
include_once("funkcije.php");

//$firebase_api_key="AAAA2bNVnkE:APA91bHaDF1WtZU-T2stHPwT3VsZtljvkGKWBiuhB_Rln49PysPnAtP6rSlVvMja4_zwer94nuc5EDD8SuZkc0yCwkPigfu7_SlaS2EMD8CGML3T4wMAUM_oPnSxZDyaAR23Y-jRzaDJz1O-G574Il_rne0zFfdjAA";
header("Content-Type:application/json");
define('FIREBASE_API_KEY', 'AAAA2bNVnkE:APA91bHaDF1WtZU-T2stHPwT3VsZtljvkGKWBiuhB_Rln49PysPnAtP6rSlVvMja4_zwer94nuc5EDD8SuZkc0yCwkPigfu7_SlaS2EMD8CGML3T4wMAUM_oPnSxZDyaAR23Y-jRzaDJz1O-G574Il_rne0zFfdjAA');
if (isset($_GET)) {
    if (!empty($_GET["metoda"])) {

        if ($_GET["metoda"] == 'registerDevice') {
            $email = $_GET["email"];
            $token = $_GET["token"];
            registerDevice($email, $token);
            //echo "registerDevice";
        }
        
         if ($_GET["metoda"] == 'sendNotifications') {
        //echo "tu\n";            
            $tokeni=getAllTokens();
            if(empty($tokeni)){
                //to do ak nema tokena
            }else{
                //to do send notification
                $title="Naslov";
                $message="Tekst notifikacije";
                $image=null;
                $res=array();
                $res['data']['title'] = $title;
                $res['data']['message'] = $message;
                $res['data']['image'] = $image;  
                sendPushNotifications($res,$tokeni);
            }
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

function getAllTokens(){
    $sql="SELECT * FROM tokeni";
    $txt = "";
    $rez = vrati_podatke($sql);
    $tokens=array();
    if ($rez->num_rows > 0) {
        while ($row = $rez->fetch_assoc()) {
            array_push($tokens, $row["token"]);
        }
    } 
    return $tokens;
}

function sendPushNotifications($rez,$tokeni){

    $url=$url = 'https://fcm.googleapis.com/fcm/send';
    $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
       // print_r($headers) ;
     $ch= curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
         $fields = array(
            'registration_ids' => $tokeni,
            'data' => $rez,
        );
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        $vraceno= json_decode($result,true);
        if($vraceno["success"]==0){
            deliver_response("NOT OK", $vraceno["success"], "Nije poslana ni jedna notifikacija", array('notifikacija'=>'nema'));
        }else{
            deliver_response("OK", $vraceno["success"], "Poslane notifikacije", array('notifikacija'=>'ima')); 
        }
        
}