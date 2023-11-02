
<?php
    session_start();
    session_destroy();

    $a=$_POST["a"]??null;
    $b=$_POST["b"]??null;
    $mod=$_POST["mod"]??null;
    $form = file_get_contents('forms.html');

    $checked="checked";
    $priklad="";
    
    //echo "a: ".$a."<br>";
    //echo "b: ".$b."<br>";
    //echo "mod: ".$mod."<br>";

    if($a==null or $b==null or $mod==null){
        //echo "nelze pocitat parametr nebyl zadan<br><br>";
    }else{
        switch ($mod) {
            case 'scitani':
                $priklad="$a+$b=".$a+$b;
                $form=str_replace("#checkedscitani#", $checked, $form);
                break;
            case 'odcitani':
                $priklad="$a-$b=".$a-$b;
                $form=str_replace("#checkedodcitani#", $checked, $form);
                break;
            case 'nasobeni':
                $priklad="$a".'×'."$b=".$a*$b;
                $form=str_replace("#checkednasobeni#", $checked, $form);
                break;
            case 'deleni':
                if($b==0){
                    $priklad="$a/$b="."Nelze delit nulou";
                }else{
                    $priklad="$a".'÷'."$b=".$a/$b;
                    $form=str_replace("#checkeddeleni#", $checked, $form);
                }
                break;
            default:
                echo "Neznama operace ".$mod;
            
        }

    }
   // $_SESSION["acko"] = $a??0;
   // $_SESSION["bcko"] = $b??0;
    $form=str_replace("#a#", $a, $form);
    $form=str_replace("#b#", $b, $form);
    $form=str_replace("#vysledek#", $priklad, $form);
    $form=str_replace("#NAZEV#", "Kalkulacka", $form);
    echo $form;
    
?>
