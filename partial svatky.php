function cas($month, $year){
    $svatky = array(date("01.01.Y"), date("01.05.Y"), date("08.05.Y"), date("05.07.Y"), date("06.07.Y"), date("28.09.Y"), date("28.10.Y"), date("17.11.Y"), date("24.12.Y"));
    $mesice=array("Leden", "Unor", "Brezen", "Duben", "Kveten", "Cerven", "Cervenec", "Srpen", "Zari", "Rijen", "Listopad", "Prosinec");
    $datum = strtotime("1.$month.$year");
    $radek = 30;
    foreach ($mesice as $key => $value) {
        if(date("n", $datum)==$key+1){
            for($m=0; $m<(($radek)-strlen($value))/2; $m++){
                echo(" ");
            }
            echo("$value");
        }
    }
    echo("\n");
    echo("  ------------------------")."\n";
    echo("     Po Ut St Ct Pa  So  Ne")."\n";
    echo date("W/ ",$datum);
    for($x=0; $x<date("N", $datum)-1; $x++){
        echo("   ");
 }
    $lastday = date("t", $datum);
    for($i=1;$i<=date("t", $datum);$i++){
        if(in_array(date("d.m.Y", $datum), $svatky)){
            
        }
    }
    
}

echo cas(2, 2023);
