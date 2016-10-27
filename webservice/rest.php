<?php

//putanja http://localhost/fooddonorwebservice/FoodDonorWebservice/php/rest.php
include_once( 'funkcije.php');
header("Content-Type:application/json");

//echo "rest.php";
if (isset($_GET)) {

    if (!empty($_GET["view"])) {
        if ($_GET["view"] == 'svi_gradovi'){ 
            sviGradovi();
        }
        
    }
}