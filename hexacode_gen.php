<?php
function hexacode_gen(){
    $finalcolor = [];
    $decimalletters = array("A", "B", "C", "D", "E", "F");
    $decimalnumbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    for($decimalfixator = 0; $decimalfixator < 6; $decimalfixator++){
        $random_piece = rand(0, 1);
        if($random_piece == 0){
            $colorcode = array_rand($decimalletters);
            $colorcode = $decimalletters[$colorcode];
        }else{
            $colorcode = array_rand($decimalnumbers);
            $colorcode = $decimalnumbers[$colorcode];
        }
        $finalcolor[] = $colorcode;
    }
    return $finalcolor;
}

print "Your Randomly Generated Color Code: "."#". (implode("",hexacode_gen()));
?>
