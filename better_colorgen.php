<?php
 function hexacode_gen(){
    $finalcolor = [];
    $decimalletters = array("A", "B", "C", "D", "E", "F");
    $decimalnumbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $fullarr = array_merge($decimalletters, $decimalnumbers);
    for($decimalfixator = 0; $decimalfixator < 6; $decimalfixator++){
            $colorcode = array_rand($fullarr);
            $colorcode = $fullarr[$colorcode];
            $finalcolor[] = $colorcode;
    }
    return $finalcolor;
}
print "Your Randomly Generated Color Code: "."#". (implode("",hexacode_gen()));
?>
