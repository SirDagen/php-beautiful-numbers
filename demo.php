<?php

require('output.php'); 

#
# --- Demo
#

echo "<p><b>The number format is set in 'output.php' (currently German):</b><br/></p>";

$q=mt_rand()/mt_getrandmax(); $u='s'; 
echo "<p>".out_sinum($q, $u)." = {$q} {$u}</p>";

$q=mt_rand()/mt_getrandmax()/1000; $u='s'; 
echo "<p>".out_sinum($q, $u)." = {$q} {$u}</p>";

$q=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".out_sinum($q, $u)." = {$q} {$u}</p>";

$q=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".out_sinum($q, $u)." = {$q} {$u}</p>";

$q=mt_rand(5, 999999); $u='B'; 
echo "<p>".out_sinum($q, $u, ['bin'=>true])." = {$q} {$u}</p>";

$q=mt_rand()/mt_getrandmax()*10000; $u='m'; 
echo "<p>".out_sinum($q, $u)." = {$q} {$u}</p>";



?>