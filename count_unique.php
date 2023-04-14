<?php
function unique($unique){
    $unique2 = array();
    foreach($unique as $key => $value){
        if(array_count_values($unique)[$value] == 1){
            $unique2[] = $value;
        }
    }
    return $unique2;
}



echo implode(", ", unique(array(1, 1, 2, 2, 3, 3, 4, 4, 5))); 

?>
