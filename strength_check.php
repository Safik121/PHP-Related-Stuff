<?php

function strength_check($password){
    if(strlen($password) < 8){
        return "Your password is really weak, try longer one!";
    }else{
        if (preg_match('/\s/', $password)){
            return "Your password format is incorrect!";
        }else{
            if(preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password)){
                if(preg_match('/[$#&@!%*.]/', $password)){
                    if(preg_match('/[0-9]/', $password)){
                        return "Your password is strong!";
                    }else{
                        return "Your password doesn't contain any numbers!";
                    }
                }else{
                    return "Your password is decently strong but it doesn't contain any special characters!";
                }
            }else{
                return "Your password is long enough but it doesn't contain capital or lowercase letters!";
            }
        }
        }
}

echo strength_check('');

?>
