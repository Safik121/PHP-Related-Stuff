<?php
session_start();

$login_form = file_get_contents("login.html");
$logged_form = file_get_contents("logged.html");
$changepass_form = file_get_contents("changepass.html");

function login($jmeno, $heslo)
{
    $file = file("dataInfo.txt");
    $logged = false;

    if ($jmeno == null || $heslo == null) {
        echo "Žádné info nezadáno";
    } else {
        foreach ($file as $value) {
            $userInfo = explode(":", $value);
            $userName = $userInfo[0];
            $passWord = isset($userInfo[1]) ? $userInfo[1] : '';
            $perms = isset($userInfo[2]) ? $userInfo[2] : '';

            if ($jmeno === trim($userName) && $heslo === trim($passWord)) {
                $logged = true;
                break;
            }
        }
    }
    return $logged;
}

function changePass($jmeno, $heslo, $noveHeslo)
{
    $file = file("dataInfo.txt");
    $vysledek = [];

    foreach ($file as $key) {
        $userInfo = explode(":", $key);
        $userName = $userInfo[0];
        $passWord = isset($userInfo[1]) ? trim($userInfo[1]) : '';
        $perms = isset($userInfo[2]) ? trim($userInfo[2]) : '';

        if ($jmeno == $userName and $heslo == $passWord) {
            $passWord = $noveHeslo;

            $vysledek[] = $userName . ":" . $passWord . ":" .$perms ."\n";
        } else {
            $vysledek[] = $key;
        }
    }
    file_put_contents("dataInfo.txt", implode("", $vysledek));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['loginn'])) {
        if (login($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
            echo $logged_form;
        } else {
            echo $login_form;
        }
    } elseif (isset($_POST['logoutt'])) {
        echo $login_form;
        session_destroy();
    } elseif (isset($_POST['changepasss'])) {
        if (!empty($_POST['newpassword'])) {
            changePass($_SESSION['username'], $_SESSION['password'], $_POST['newpassword']);
            $_SESSION['password'] = $_POST['newpassword'];
            echo $login_form;
    }
    } elseif (isset($_POST['tochange'])) {
        echo $changepass_form;
    } elseif (isset($_POST['bckk'])) {
        if (isset($_SESSION['username']) && isset($_SESSION['password']) && login($_SESSION['username'], $_SESSION['password'])) {
            $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
            echo $logged_form;
        }
    }
} else {
    echo $login_form;
}
?>
