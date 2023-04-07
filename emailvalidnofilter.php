function validator($mail){
    $part = explode("@", $mail);
    if(count($part)!=2){
        return ("not valid email format");
    }else{
        $continue = explode(".", $part[1]);
        if(count($continue)!=2){
            return ("not valid email adress!");
        }else{
            return ("valid email");
        }
    }
}
