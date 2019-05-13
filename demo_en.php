<?php

require('bformat-class.php'); 

#
# --- Demo: English 
#


// Create a new instance - English number format
$bf = new PHPbf\bformat( ['lang'=>'en'] );

echo "<br/><h1>php-beautiful-numbers <b>(format = ".$bf->langname().")</b><br/></h1>"; 


// sinum()
echo "<br/><h3><pre>A. \"sinum\": Outputs numbers in easy readable SI format</pre></h3>";

$val=mt_rand()/mt_getrandmax(); $u='s'; 
echo "<p>".$bf->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>"; 

$val=mt_rand()/mt_getrandmax()/1000; $u='s'; 
echo "<p>".$bf->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".$bf->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".$bf->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$bf->sinum($val, $u, ['bin'=>true])." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$bf->sinum($val, $u, ['acc'=>2])." &nbsp;(= {$val} {$u})</p>"; // accuracy is set to 2 decimal digits


// tnum()
echo "<br/><h3><pre>B. \"tnum\": Outputs numbers inside running text (1..12 will be written-out)</pre></h3>";

// outputs 1..12 written-out, all others as digits (as common practice in publications)
echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(2, 15); 
    echo "There are ".$bf->tnum($val)." trees on the hill.<br/>"; 
}
echo "</p>"; 


echo "<p><i>But also decimals (if needed):</i></p>";

$val=mt_rand()/mt_getrandmax()*2;
echo "<p>The mean is ".$bf->tnum($val, 1)." children.</p>"; 



echo "<br/>&nbsp;<br/>";


?>
