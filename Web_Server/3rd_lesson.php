<?php
$a = $_POST['a']??null;
$b = $_POST['b']??null;
$mod = $_POST['q']??null;

function scitani($a, $b){
    $vysledek = $a + $b;
    return $vysledek;
}
function odcitani($a, $b){
    $vysledek = $a - $b;
    return $vysledek;
}
function nasobeni($a, $b){
    $vysledek = $a * $b;
    return $vysledek;
}
function deleni($a, $b){
    if($b == 0){
        $vysledek = "ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ SUS ERRORUS ඞ ඞ ඞ ඞ ඞ ඞ ඞ ඞ";
        return $vysledek;
    }else{
        $vysledek = $a / $b;
        return $vysledek;
    }
}
$vysledek = null;
$znamenko = null;
$rovnitko = null;
if($mod == "Plus"){
    //echo $a ." + ". $b ." = ". scitani($a, $b);
    $vysledek = scitani($a, $b);
    $znamenko = "+";
    $rovnitko = "=";
}elseif($mod == "Minus"){
    //echo $a ." - ". $b ." = ". odcitani($a, $b);
    $vysledek = odcitani($a, $b);
    $znamenko = "-";
    $rovnitko = "=";
}elseif($mod == "Krat"){
    //echo $a ." * ". $b ." = ". nasobeni($a, $b);
    $vysledek = nasobeni($a, $b);
    $znamenko = "*";
    $rovnitko = "=";
}elseif($mod == "Deleno"){
    //echo $a ." / ". $b ." = ". deleni($a, $b);
    $vysledek = deleni($a, $b);
    $znamenko = "/";
    $rovnitko = "=";
}
?>

<form action="get.php" method="post">
        <input type="text" name="a" value = "<?php echo $a;?>"><br>
        <input type="text" name="b"value = "<?php echo $b;?>"><br>
        <input type="radio" name="q" value="Plus" <?php if ($mod == "Plus") echo 'checked'; ?>> Secti <br>
        <input type="radio" name="q" value="Minus" <?php if ($mod == "Minus") echo 'checked'; ?>> Odcitej <br>
        <input type="radio" name="q" value="Krat" <?php if ($mod == "Krat") echo 'checked'; ?>> Nasob <br>
        <input type="radio" name="q" value="Deleno" <?php if ($mod == "Deleno") echo 'checked'; ?>> Del <br>
        <input type="submit" value="Calculate"><br>
        <input type="text" name = "idk" value = "<?php echo $a, $znamenko, $b, $rovnitko, $vysledek;?>" readonly>
</form>
