<?php
$a = $_GET['a'];
$b = $_GET['b'];
$mod = $_GET['mod'];

if($mod == "secti"){
    echo $a ."+". $b ."=". $a+$b;
}elseif($mod == "odecti"){
    echo $a ."-". $b ."=". $a-$b;
}elseif($mod == "nasob"){
    echo $a ."*". $b ."=". $a*$b;
}elseif($mod == "del"){
    if($b==0){
        echo "error";
    }else{
        echo $a ."/". $b ."=". $a/$b;
    }
}
