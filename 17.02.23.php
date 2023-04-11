<?php
function cas($month, $year){
    $mesice=array("Leden", "Unor", "Brezen", "Duben", "Kveten", "Cerven", "Cervenec", "Srpen", "Zari", "Rijen", "Listopad", "Prosinec");
    $datum = strtotime("1.$month.$year");
    $radek = 28;
    foreach ($mesice as $key => $value) {
        if(date("n", $datum)==$key+1){
            for($m=0; $m<(($radek)-strlen($value))/2; $m++){
                echo(" ");
            }
            echo("$value");
        }
    }
    echo("\n");
    echo("    --------------------")."\n";
    echo("    Po Ut St Ct Pa So Ne")."\n";
    echo date("W/ ",$datum);
    for($x=0; $x<date("N", $datum)-1; $x++){
        echo("   ");
 }
    $lastday = date("t", $datum);
    for($i=1;$i<=date("t", $datum);$i++){
        if($i<10){
            echo (" $i ");
        }else{
            echo ("$i ");
        }
        if(date("N", $datum)==7){
            echo("\n");

        }
        if($i!=$lastday){
            $datum = strtotime("+ 1 day",$datum);
        }
           if(date("l", $datum)=="Monday"){
            echo date("W/ ", $datum);
        }
    }
    
}

echo cas(12, 2023)
?>
