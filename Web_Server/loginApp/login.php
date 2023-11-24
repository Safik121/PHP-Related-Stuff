<?php
session_start();
session_destroy();

$login_form = file_get_contents("login.html");
$logged_form = file_get_contents("logged.html");
$username = $_POST['username']??null;
$password = $_POST['password']??null;

$users = array("Martin"=>"Martinek123", "Max"=>"Maxicek123", "Dan"=>"Danicek123");

function login($jmeno, $heslo, $uzivatele){
    $logged = false;
    $username = $jmeno;
    $password = $heslo;
    $users = $uzivatele;
    if ($username == null or $password == null) {
        echo("Žádné info nezadáno");
    }else {
        foreach ($users as $user => $value) {
           if($username == $user && $password == $value){
            $logged = true;
            break;
           }
           else{
            $logged = false;
           }
        }
    }
    return $logged;
}

function changePass($jmeno, $heslo, $noveHeslo){
    
}

if(login($username, $password, $users) == true){
    $logged_form = str_replace('#username#', $username, $logged_form);
    echo($logged_form);
}else{
    echo($login_form);
}


?>
