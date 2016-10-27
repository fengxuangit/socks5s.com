<?php
//打折信息
function GetMoneyCount($month, $price){
    switch ($month) {
        case 1:
            return $price;
            break;
        case 6:
            return $price * ($month - 1) ;
            break;
        case 12:
            return $price * ($month - 2) ;
            break;
    }
    
 }

?>