<?php

require('bnformat-class.php'); 

#
# --- Demo: Deutsch
#


// Neue Instanz anlegen - Deutsches Nummberformat
$bn = new bnformat\bnformat( ['lang'=>'de'] ); 

echo "<br/><h1>php-beautiful-numbers <b>(Format = ".$bn->langname().")</b><br/></h1>"; 


// sinum()
echo "<br/><h3><pre>A. \"sinum\": Gibt Zahlen im einfach zu lesenden SI-Format aus</pre></h3>";

$val=mt_rand()/mt_getrandmax(); $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>"; 

$val=mt_rand()/mt_getrandmax()/1000; $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$bn->sinum($val, $u, ['bin'=>true])." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$bn->sinum($val, $u, ['acc'=>2])." &nbsp;(= {$val} {$u})</p>"; // Genauigkeit = 2 Stellen


// tnum()
echo "<br/><h3><pre>B. \"tnum\": Gibt Zahlen im Fließtext aus (0..12 werden ausgeschrieben)</pre></h3>";

// Zahlen 0..12 werden ausgeschrieben, alle anderen als Zahlen ausgegeben (wie es in Publikationen üblich ist)
echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(2, 15); 
    echo "Es sind ".$bn->tnum($val)." Bäume auf der Anhöhe.<br/>"; 
}
echo "</p>"; 



echo "<br/>&nbsp;<br/>";


?>
