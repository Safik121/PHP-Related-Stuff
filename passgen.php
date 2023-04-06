function passgen(){
    $length = rand(14, 22);
    $number = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $Bletters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "Q", "X", "Y", "Z");
    $sletters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "q", "x", "y", "z");
    $scharacters = array("$", "#", "&", "@", "!", "%", "*");

    $characters = array_merge($number, $Bletters, $sletters, $scharacters);
    $longmunber = count($characters);
    $startingpoint = rand(0, $longmunber - $length);
    shuffle($characters);
    $password = substr(implode($characters), $startingpoint, $length);
    return $password;
}
