<?php

require('PHPzformat.php'); 

#
# --- Demo: Deutsch
#


// Neue Instanz anlegen - Deutsches Nummberformat
$zformat = new PHPzformat\zformat( ['lang'=>'de'] ); 

echo "<br/><h1><b>Das Nummerformat ist ".$zformat->langname().":</b><br/></h1>"; 


// sinum()
echo "<h3><pre>A. \"sinum\": Gibt Zahlen im einfach zu lesenden SI-Format aus</pre></h3>";

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
echo "<p>".$zformat->sinum($val, $u, ['acc'=>2])." &nbsp;(= {$val} {$u})</p>"; // Genauigkeit = 2 Stellen


// outnum()
echo "<br/><h3><pre>B. \"outnum\": Gibt Zahlen im Fließtext aus (1..12 werden ausgeschrieben)</pre></h3>";

// Zahlen 1..12 werden ausgeschrieben, alle anderen als Zahlen ausgegeben (wie es in Publikationen üblich ist)
echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(2, 15); 
    echo "Es sind ".$zformat->outnum($val)." Bäume auf der Anhöhe.<br/>"; 
}
echo "</p>"; 


echo "<p><i>Aber auch Kommazahlen (wenn benötigt):</i></p>";

$val=mt_rand()/mt_getrandmax()*2;
echo "<p>Das Mittel liegt bei ".$zformat->outnum($val, 1)." Kindern.</p>"; 



echo "<br/>&nbsp;<br/>";


?>