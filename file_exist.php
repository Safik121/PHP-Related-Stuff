<?php
function nactusoubor($a, $b){
    $vystup = "";
    $adr = scandir($b);
    $seznam = $a;
    $file = file($seznam, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    //$jmeno_array = array();
    $beztxt_array = array();
    $final_array = array();
    foreach($adr as $key => $value){
        if($value == "." or $value == ".."){
            unset($adr[$key]);
        }else{
            $adr[$key] = str_replace(".txt", "", $adr[$key]);
            $beztxt_array[] = $adr[$key];
        }
    }
    foreach($file as $key => $value){
        if(in_array($value, $beztxt_array)){
            $size = filesize($b . "\\" . $value . ".txt");
            $vystup .= $value." - existuje - délka: ".$size." B\n";
        }else{
            $vystup .= $value." - neexistuje". "\n";
        }
    }

    foreach($beztxt_array as $key => $value){
        if(!in_array($value, $file)){
            $size = filesize($b . "\\" . $value . ".txt");
            $vystup .= $value." - existuje ale není na seznamu - délka: ".$size." B\n";
        }
    }
    return $vystup;
}

$result = nactusoubor("H:\Programkoxd\seznam.txt", "H:\Programkoxd\data");
echo $result."\n";
$nazev_souboru = date("Ymd-His").".log";
$cesta = "H:\\Programkoxd\\log\\".$nazev_souboru;
file_put_contents($cesta, $result);
echo "soubor vytvořen v: $cesta";
?>
