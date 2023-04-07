function validateEmail($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == true){
        return ("Email adress is valid!");
    }else{
        return("That is not valid email adress!");
    }
 }
