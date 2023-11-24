<?php
$file = file("dataInfo.txt");
$vysledek = array();
foreach ($file as $key) {
    $userName = explode(":", $key)[0];
    $password = explode(":", $key)[1];
    
    print_r($userName);
    //echo("\n");
    print_r($password);
}
