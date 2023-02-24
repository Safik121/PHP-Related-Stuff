if($i<10){
            if(date("w", $datum)== 0 or date("w", $datum)== 6){

                echo ("[ $i]");

            }else{
                echo (" $i ");
            }
        }else{
            if(date("w", $datum)== 0 or date("w", $datum)== 6){
                echo ("[$i]");
            }else{
                echo ("$i ");
            }
        }
        if(date("N", $datum)==7){
            echo("\n");

        }
        if($i!=$lastday){
            $datum = strtotime("+ 1 day",$datum);
        }
        if(date("l", $datum)=="Monday" and $i != $lastday){
            echo date("W/ ", $datum);
        }
