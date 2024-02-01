<?php
session_start();
$login_form = file_get_contents("login.html");
$logged_form = file_get_contents("logged.html");
$adminpanel = file_get_contents("admin_panel.html");
$changepass_form = file_get_contents("changepass.html");
$adduser_form = file_get_contents("adduzivatel.html");
$zmenaUzivatele_form = file_get_contents("zmena_od_admina.html");

function openCon(){
    $host = "localhost";
    $db_name = "kekejda";
    $db_user = "safik";
    $db_pass = "safik";

    $conn = new mysqli($host, $db_user, $db_pass, $db_name) or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}

function closeCon($conn){
    $conn->close();
}

function loadInfoFromDB($table, $conn){
    $tableName = $table;
    $sql_id = "SELECT id FROM $tableName";
    $sql_jmeno = "SELECT name FROM $tableName";
    $sql_heslo = "SELECT password FROM $tableName";
    $sql_role = "SELECT role FROM $tableName";

    $result_id = $conn->query($sql_id);
    $result_jmeno = $conn->query($sql_jmeno);
    $result_heslo = $conn->query($sql_heslo);
    $result_role = $conn->query($sql_role);

    // Check if the queries were successful
    if ($result_id && $result_jmeno && $result_heslo && $result_role) {
        $data = array(
            'id' => $result_id->fetch_all(MYSQLI_ASSOC),
            'name' => $result_jmeno->fetch_all(MYSQLI_ASSOC),
            'password' => $result_heslo->fetch_all(MYSQLI_ASSOC),
            'role' => $result_role->fetch_all(MYSQLI_ASSOC),
        );

        return $data;
    } else {
        echo "Error executing queries: " . $conn->error . "\n";
        return false;
    }
}

function loadUsers(){
    $file = file("dataInfo.txt");
    $userList = [];
    $random_count = 0;

    $select1 = '<select name="acesslevel">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>';
    $select2 =  '<select name="acesslevel">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>';

    $tabulka = '<style>
    /* Container to left-align the table */s
    .table-container {
        display: flex;
        justify-content: flex-start;
    }

    /* Style the table */
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border-radius: 8px;
        background: linear-gradient(180deg, #001f3f 0%, #003366 100%);
        margin-left: -100px;
    }

    /* Style the table header */
    th {
        background-color: #004080;
        color: white;
        border: 1px solid #001f3f;
        text-align: left;
        padding: 12px;
        font-weight: bold;
        border-radius: 8px 0 0 0;
    }

    /* Style the table cells */
    td {
        border: 1px solid #001f3f;
        text-align: left;
        padding: 12px;
        border-radius: 0 0 8px 0;
        color: white; /* Set text color to white */
    }

    /* Alternate row background color */
    tr:nth-child(even) {
        background-color: #002b4d;
    }

    /* Hover effect on table rows */
    tr:hover {
        background-color: #003366;
    }
</style>
';
    $tabulka .= '<form action="login.php" method="post">';
    $tabulka .= '<div class="table-container">';
    $tabulka .= '<table>';
    $tabulka .= '<tr><th>Jmeno</th><th>Role</th><th>Nové Heslo</th><th>Odeslat</th></tr>';


    foreach ($file as $key){
        $everything = explode(":", $key);
        array_push($userList, $everything[0].":".$everything[2]);
    }
    //print_r($userList);
    foreach ($userList as $user){
       $prosimUzNe = explode(":", $user);
       $nejakejmeno = $prosimUzNe[0];
       $nejakarole = $prosimUzNe[1];

       $tabulka .= '<tr>';
       $tabulka .= '<td>'. $nejakejmeno . '</td>';
       if(trim($nejakarole)=="Admin"){
        $tabulka .= '<td><select class = "random_div" name="' . $nejakejmeno .'_acesslevel">
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select></td>';
       }elseif(trim($nejakarole)=="User"){
        $tabulka .= '<td><select class = "random_div" name="' . $nejakejmeno .'_acesslevel">
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select></td>';
       }
       $tabulka .= '<td>
                        <input type="password" name="' . $nejakejmeno . '_newheslo" value="" placeholder="New Password">
                    </td>';
       $tabulka .= '<td>
                        <input type="hidden" name="action" value="changepass">
                        <input class="button-33" type="submit" name="changepass_' . $nejakejmeno . '" value="Change Info">
                    </td>';
       $tabulka .= '</tr>';
   }

    $tabulka .= '</table>';
    $tabulka .= '</form>';
    return $tabulka .= '</div>';
}

function login($jmeno, $heslo)
{
    $conn = OpenCon();
    $_SESSION['logged'] = false;
    $converted_perms = '';

    if ($jmeno == null || $heslo == null) {
        //echo "Žádné info nezadáno";
    } else {
        $tableName = 'users';

        $sql = "SELECT name, password, role FROM $tableName WHERE name = ? AND password = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $jmeno, $heslo);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userName = $row['name'];
            $passWord = $row['password'];
            $perms = $row['role'];

            if ($jmeno === trim($userName) && $heslo === trim($passWord)) {
                $_SESSION['logged'] = true;
                $converted_perms = trim($perms);
            }
        } else {
            echo "User not found or incorrect password.\n";
        }

        // Close the statement
        $stmt->close();
    }

    CloseCon($conn);

    return array($_SESSION['logged'], $converted_perms);
}

function changePass($heslo, $noveHeslo) {
    $file = file("dataInfo.txt");
    $vysledek = [];

    foreach ($file as $key) {
        $userInfo = explode(":", $key);
        $userName = $userInfo[0];
        $passWord = isset($userInfo[1]) ? trim($userInfo[1]) : '';
        $perms = isset($userInfo[2]) ? trim($userInfo[2]) : '';

        if ($_SESSION['username'] == $userName) {
            if ($heslo == $passWord) {
                if (strpos($noveHeslo, ':') === false) {
                    if (strlen($noveHeslo) > 2) {
                        $passWord = $noveHeslo;
                        $vysledek[] = $userName . ":" . $passWord . ":" . $perms . "\n";
                    } else {
                        $vysledek[] = $key;
                        $error = "Heslo moc krátké!";
                        print('<div><input id="prvnid" type="text" name="errorik" value="Heslo moc krátké!" readonly></div><br>');
                    }
                } else {
                    $vysledek[] = $key;
                    $error = "Heslo obsahuje nepovolený znak!";
                    print('<div><input id="prvnid" type="text" name="errorik" value="Heslo obsahuje nepovolený znak!" readonly></div><br>');
                }
            } else {
                $vysledek[] = $key;
                print('<div><input id="prvnid" type="text" name="errorik" value="Špatné heslo!" readonly></div><br>');
            }
        } else {
            $vysledek[] = $key;
        }
    }
    file_put_contents("dataInfo.txt", implode("", $vysledek));
}

function changePass2($jmeno, $noveHeslo, $novaPerm) {
    $file = file("dataInfo.txt");
    $vysledek = [];
    $errorPrinted = false;

    foreach ($file as $key) {
        $userInfo = explode(":", $key);
        $userName = $userInfo[0];
        $passWord = isset($userInfo[1]) ? trim($userInfo[1]) : '';
        $perms = isset($userInfo[2]) ? trim($userInfo[2]) : '';

        if (strpos($noveHeslo, ':') === false) {
            if (!(strlen($noveHeslo) < 3)) {
                if ($jmeno == $userName && $jmeno != $_SESSION['username']) {
                    $passWord = $noveHeslo;
                    $perms = $novaPerm;

                    $vysledek[] = $userName . ":" . $passWord . ":" . $perms . "\n";
                } else {
                    $vysledek[] = $key;
                }
            } elseif ($jmeno == $userName && $jmeno != $_SESSION['username'] && !$errorPrinted) {
                if ($perms != $novaPerm) {
                    $passWord = $noveHeslo;
                    $perms = $novaPerm;

                    $vysledek[] = $userName . ":" . $passWord . ":" . $perms . "\n";
                } else {
                    $vysledek[] = $key;

                    if (!$errorPrinted) {
                        $errorPrinted = true;
                    }
                }
            } else {
                $vysledek[] = $key;
            }
        } else {
            $vysledek[] = $key;
            $errorPrinted = true;
        }
    }
    if ($errorPrinted){
        print('<div><input id="prvnid" type="text" name="errorik" value="Heslo není povoleno!" readonly></div><br>');
    }

    file_put_contents("dataInfo.txt", implode("", $vysledek));
}





function pridameUzivatele($jmeno, $heslo, $prava) {

    if (!(strlen($jmeno) == 0 || strlen($heslo) < 3)) {
        $userExists = false;

        foreach (file("dataInfo.txt") as $key) {
            $userinformace = explode(":", $key);
            if ($jmeno == $userinformace[0]) {
                $userExists = true;
                break;
            }
        }

        if (!$userExists) {
            $newuser = $jmeno . ":" . $heslo . ":" . $prava . "\n";
            file_put_contents("dataInfo.txt", $newuser, FILE_APPEND | LOCK_EX);
        } else {
            print('<div><input id="prvnid" type="text" name="errorik" value="Uživatel již existuje!" readonly></div><br>');
        }
    } else {
        if (strlen($jmeno) == 0) {
            print('<div><input id="prvnid" type="text" name="errorik" value="Moc krátké jméno!" readonly></div><br>');
        }
        if (strlen($heslo) < 3) {
            print('<div><input id="prvnid" type="text" name="errorik" value="Moc krátké heslo!" readonly></div><br>');
        }
    }
}


function adminMeniUzivatele($jmenoUzivatele, $noveHeslo, $noveOpravneni){
    $fileWithUsers = file("dataInfo.txt");
    $finalArray = [];
    if ($jmenoUzivatele == $_SESSION['username']){
        print('<div><input id="prvnid" type="text" name="errorik" value="Měníš sám sebe!" readonly></div><br>');
    } else{
        foreach ($fileWithUsers as $key){
            $infoOuserech = explode(":", $key);
            $userNejm = $infoOuserech[0];
            $puvodniHeslo = isset($infoOuserech[1]) ? trim($infoOuserech[1]) : '';
            $puvodniPerms = isset($infoOuserech[2]) ? trim($infoOuserech[2]) : '';

            if ($jmenoUzivatele == $userNejm){
                if(strlen($noveHeslo)>2){
                    $puvodniHeslo = $noveHeslo;
                    $puvodniPerms = $noveOpravneni;
    
                    $finalArray[] = $userNejm . ":" . $puvodniHeslo . ":" . $puvodniPerms . "\n";
                }else {
                    $finalArray[] = $key;
                    print('<div><input id="prvnid" type="text" name="errorik" value="Moc krátké heslo!" readonly></div><br>');
                }
            } else {
                $finalArray[] = $key;
            }
        }
        file_put_contents("dataInfo.txt", implode("", $finalArray));
    }
}

function smazatUzivatele($jmeno){
    $suboruzivatelksy = file("dataInfo.txt");
    $konecnyArray = [];

    if($jmeno == $_SESSION['username']){
        //print("Admine Nezlob!");
    } else {
        foreach($suboruzivatelksy as $key){
            $infoOuserechNaposled = explode(":", $key);
            $posledniName = $infoOuserechNaposled[0];

            if($jmeno != $posledniName){
                $konecnyArray[] = $key;
            }
        }
        file_put_contents("dataInfo.txt", implode("", $konecnyArray));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['loginn'])) {
        list($booll, $pristup) = (login($_POST['username'], $_POST['password']));
        if ($booll) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
            $adminpanel = str_replace('#username#', $_SESSION['username'], $adminpanel);
            if($pristup == "Admin"){
                echo $adminpanel;
                print loadUsers();
            }elseif($pristup == "User"){
                echo $logged_form;
            }
        } else {
            echo $login_form;
            print('<div><input id="prvnid" type="text" name="errorik" value="Špatné přihlašovací údaje!" readonly></div><br>');
        }
    } elseif (isset($_POST['logoutt'])) {
        echo $login_form;
    } elseif (isset($_POST['changepasss'])) {
        if (!empty($_POST['newpassword'])) {
            changePass($_POST['oldpassword'], $_POST['newpassword']);
            $_SESSION['password'] = $_POST['newpassword'];
            echo $login_form;
    }
    } elseif (isset($_POST['tochange'])) {
        $changepass_form = str_replace('#username#', $_SESSION['username'], $changepass_form);
        echo $changepass_form;
    } elseif (isset($_POST['bckk'])) {
        if ($_SESSION['logged'] ?? false) {
            list($booll, $pristup) = login($_SESSION['username'], $_SESSION['password']);
            if ($booll) {
                $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
                $adminpanel = str_replace('#username#', $_SESSION['username'], $adminpanel);
                if ($pristup == "Admin") {
                    echo $adminpanel;
                    print loadUsers();
                } elseif ($pristup == "User") {
                    echo $logged_form;
                }
            } else {
                echo $login_form;
            }
        } else {
            echo $login_form;
        }
    } elseif (isset($_POST['add_user'])){
        $adduser_form = str_replace('#username#', $_SESSION['username'], $adduser_form);
        echo $adduser_form;
    } elseif (isset($_POST['adduserpls'])){
        pridameUzivatele($_POST['username'], $_POST['password'], $_POST['acesslevel']);
        $adduser_form = str_replace('#username#', $_SESSION['username'], $adduser_form);
        echo $adduser_form;
    } elseif (isset($_POST['change_user_jojo'])){
        $zmenaUzivatele_form = str_replace('#username#', $_SESSION['username'], $zmenaUzivatele_form);
        echo $zmenaUzivatele_form;
    } elseif (isset($_POST['changeuserpls'])){
        adminMeniUzivatele($_POST['usersname'], $_POST['newuserpassword'], $_POST['newacesslevel']);
        $zmenaUzivatele_form = str_replace('#username#', $_SESSION['username'], $zmenaUzivatele_form);
        echo $zmenaUzivatele_form;
    } elseif (isset($_POST['deleteuserpls'])){
        $zmenaUzivatele_form = str_replace('#username#', $_SESSION['username'], $zmenaUzivatele_form);
        smazatUzivatele($_POST['usersname']);
        echo $zmenaUzivatele_form;
    } elseif(isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'changepass':
                $file = file("dataInfo.txt");
                foreach ($file as $user) {
                    $prosimUzNe = explode(":", $user);
                    $nejakejmeno = $prosimUzNe[0];
                    if (!empty($_POST['changepass_' . $nejakejmeno])) {
                        $newPassword = $_POST[$nejakejmeno . '_newheslo'];
                        $newPermxd = $_POST[$nejakejmeno . '_acesslevel'];
                        changePass2($nejakejmeno, $newPassword, $newPermxd);
                        if ($_SESSION['logged'] ?? false) {
                            list($booll, $pristup) = login($_SESSION['username'], $_SESSION['password']);
                            if ($booll) {
                                $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
                                $adminpanel = str_replace('#username#', $_SESSION['username'], $adminpanel);
                                if ($pristup == "Admin") {
                                    echo $adminpanel;
                                    print loadUsers();
                                } elseif ($pristup == "User") {
                                    echo $logged_form;
                                }
                            } else {
                                echo $login_form;
                            }
                        } else {
                            echo $login_form;
                        }
                    }
                }
        }
    }
} elseif($_SESSION['logged']??false) {
    list($booll, $pristup) = login($_SESSION['username'], $_SESSION['password']);
    if ($booll) {
        $logged_form = str_replace('#username#', $_SESSION['username'], $logged_form);
        $adminpanel = str_replace('#username#', $_SESSION['username'], $adminpanel);
        if($pristup == "Admin"){
            echo $adminpanel;
            print loadUsers();
        }elseif($pristup == "User"){
            echo $logged_form;
        }
    }
} else {
    echo $login_form;
    //print_r(loadInfoFromDB("users", openCon()));
}
?>
