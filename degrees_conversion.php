<?php
function degrees($degree, $type, $want){
    if($type == "F"){
        $base = 32;
        if ($want == "C") {
            return (($degree - $base) * 5/9);
        } elseif ($want == "K"){
            return ((($degree - $base) * 5/9) + 273.15);
        }
        else{
            return ("Input valid type please!");
        }
    } elseif ($type == "C"){
        $base = 0;
        if ($want == "K") {
            return ($degree + 273.15);
        } elseif ($want == "F"){
            return (($degree * 9/5) + 32);
        }
        else{
            return ("Input valid type please!");
        }
    } elseif ($type == "K"){
        $base = 273.15;
        if ($want == "C") {
            return ($degree - $base);
        } elseif ($want == "F"){
            return ((($degree - $base) * 9/5) + 32);
        } else {
            return ("Input valid type please!");
        }

    } else {
        return ("Input valid type please!");
    }

}

echo degrees(15 ,"K", "C");
?>
