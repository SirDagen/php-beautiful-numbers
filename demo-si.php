<?php

require('PHPzformat.php'); 

function out_demo($zformat) {
    $val=mt_rand()/mt_getrandmax(); $u='s'; 
    echo "<p>".$zformat->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>"; 
    
    $val=mt_rand()/mt_getrandmax()/1000; $u='s'; 
    echo "<p>".$zformat->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";
    
    $val=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
    echo "<p>".$zformat->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";
    
    $val=mt_rand()/mt_getrandmax()*2000; $u='g'; 
    echo "<p>".$zformat->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";
    
    $val=mt_rand(5, 1999999); $u='B'; 
    echo "<p>".$zformat->sinum($val, $u, ['bin'=>true])." &nbsp;(= {$val} {$u})</p>";
    
    $val=mt_rand()/mt_getrandmax()*9000; $u='m'; 
    echo "<p>".$zformat->sinum($val, $u, ['acc'=>2])." &nbsp;(= {$val} {$u})</p>"; // accuracy is set to 4 decimal digits
}


#
# --- Demo sinum: sinum($value, $unit, ['acc'=>3, 'bin'=>false])
#


// Create a new instance - German number format
$zformat = new PHPzformat\zformat([',', '.']); 
echo "<br/><p><b>Das Nummerformat ist Deutsch:</b><br/></p>"; 
out_demo($zformat);


// Create a new instance - English number format
$zformat = new PHPzformat\zformat(['.', ','], ['txt'=>false, 'acc'=>3]);
echo "<br/><p><b>The number format is set to English:</b><br/></p>"; 
out_demo($zformat);



?>
