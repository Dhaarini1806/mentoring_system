<?php

function riskLevel($attendance,$marks){

if($attendance < 75 || $marks < 50){
return "HIGH RISK";
}

if($attendance >=75 && $attendance <=85){
return "MEDIUM RISK";
}

return "SAFE";

}
?>