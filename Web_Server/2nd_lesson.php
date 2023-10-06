<form action="get.php" method="post">
        <input type="text" name="a"><br>
        <input type="text" name="b"><br>
        <input type="radio" name="q" value="Plus"> Secti <br>
        <input type="radio" name="q" value="Minus"> Odcitej <br>
        <input type="radio" name="q" value="Krat"> Nasob <br>
        <input type="radio" name="q" value="Deleno"> Del <br>
        <input type="submit" value="Calculate"><br>
</form>

<?php
/*$a = $_GET['a'];
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
        echo "ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ SUS ERRORUS ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ";
    }else{
        echo $a ."/". $b ."=". $a/$b;
    }
}*/


$a = $_POST['a'];
$b = $_POST['b'];
$mod = $_POST['q'];

if($mod == "Plus"){
    echo $a ."+". $b ."=". $a+$b;
}elseif($mod == "Minus"){
    echo $a ."-". $b ."=". $a-$b;
}elseif($mod == "Krat"){
    echo $a ."*". $b ."=". $a*$b;
}elseif($mod == "Deleno"){
    if($b==0){
        echo "ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ SUS ERRORUS ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ";
    }else{
        echo $a ."/". $b ."=". $a/$b;
    }
}
