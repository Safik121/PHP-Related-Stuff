<?php
function unique($unique){
    $unique2 = array();
    foreach($unique as $key => $value){
        if(array_count_values($unique)[$value] == 1){
            $unique2[] = $value;
        }
    }
    if(count($unique2) == 0){
        return "No unique values";
    }else{
        return implode(", ",$unique2);
    }
}

echo unique(array("ahoj", "ahoj", "jj", "cs")); 

?>
