<?php
function palival($palindrome){
    if(strlen($palindrome)<4){
        echo("Your word is too short so I'm not going to bother telling you!");
    }else{
        $tmps = strtolower(preg_replace('/\W+/', '', $palindrome));
        $tmpb = strrev($tmps);
        if($tmps == $tmpb){
            echo("Palindrome");
        }else{
            echo("Not palindrome");
        }
    }
}
?>
