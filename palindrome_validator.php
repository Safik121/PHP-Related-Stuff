<?php
function palival($palindrome){
    $tmps = strtolower(preg_replace('/\W+/', '', $palindrome));
    $tmpb = strrev($tmps);
    if($tmps == $tmpb){
        echo("Palindrome");
    }else{
        echo("Not palindrome");
    }
}
?>
