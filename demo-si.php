<?php

require('PHPzformat.php'); 


#
# --- Demo sinum: sinum($value, $unit, ['acc'=>3, 'bin'=>false])
#

// Create a new instance
$zformat = new PHPzformat\zformat([',', '.']); // German number format

echo "<br/><p><b>Das Nummerformat ist Deutsch:</b><br/></p>"; 

$q=mt_rand()/mt_getrandmax(); $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>"; 

$q=mt_rand()/mt_getrandmax()/1000; $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$zformat->sinum($q, $u, ['bin'=>true])." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$zformat->sinum($q, $u, ['acc'=>4])." &nbsp;(= {$q} {$u})</p>"; // accuracy is set to 4 decimal digits

 

// Create a new instance
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

echo "<br/><p><b>The number format is set to English:</b><br/></p>"; 

$q=mt_rand()/mt_getrandmax(); $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>"; 

$q=mt_rand()/mt_getrandmax()/1000; $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".$zformat->sinum($q, $u)." &nbsp;(= {$q} {$u})</p>";

$q=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$zformat->sinum($q, $u, ['bin'=>true])." &nbsp;(= {$q} {$u})</p>";
 
$q=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$zformat->sinum($q, $u, ['acc'=>4])." &nbsp;(= {$q} {$u})</p>"; // accuracy is set to 4 decimal digits



?>