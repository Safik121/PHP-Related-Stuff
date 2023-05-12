<?php
class obdelnik{
    public $a;
    public $b;
    public $typ;
    public $jednotky;   



    function __construct($a, $b, $typ, $jednotky){
        $this -> stranaA = $a;
        $this -> stranaB = $b;
        $this -> typ = $typ;
        $this -> jednotky = $jednotky;
        $this -> vypocet();

    }

    function vypocet(){
        if($this -> stranaA == 0 or $this -> stranaB == 0){
            echo "Špatný čísla";
        }else{
            if($this -> typ == true){
                echo "Obvod obdelníku je: ". ($this -> stranaA * 2) + ($this -> stranaB * 2). $this -> jednotky."\n";
            }else{
                echo "Plocha obdelníku je: ". ($this -> stranaA ) * ($this -> stranaB). $this -> jednotky."^2"."\n";
            }
        }
    }

    function __destruct(){
        echo "Výpočet dokončen"."\n";
    }
}

$student1 = new obdelnik(12, 6, false, "m");
?>
