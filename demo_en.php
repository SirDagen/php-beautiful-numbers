<?php

require('bnformat-class.php'); 

#
# --- Demo: English 
#


// Create a new instance - English number format
$bn = new bnformat\bnformat( ['lang'=>'en'] );

echo "<br/><h1>php-beautiful-numbers <b>(format = ".$bn->langname().")</b><br/></h1>"; 


// sinum()

echo "<br/><h3><pre>A. sinum() &ndash; Outputs numbers in easy readable SI format</pre></h3>";

$val=mt_rand()/mt_getrandmax()/5; $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>"; 

$val=mt_rand()/mt_getrandmax()/2000; $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()/10000000; $u='s'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*2000; $u='g'; 
echo "<p>".$bn->sinum($val, $u)." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$bn->sinum($val, $u, ['bin'=>true])." &nbsp;(= {$val} {$u})</p>";

$val=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$bn->sinum($val, $u, ['acc'=>2])." &nbsp;(= {$val} {$u})</p>"; // accuracy is set to 2 decimal digits

echo "<p><br/><b>kilo, Mega, Giga, Tera, ...</b></p>";

$val=round(mt_rand()/mt_getrandmax()*1000000); 
echo "<p>".$bn->sinum($val)." &nbsp;(= {$val})</p>"; 

$val=round(mt_rand()/mt_getrandmax()*90000000); 
echo "<p>".$bn->sinum($val)." &nbsp;(= {$val})</p>"; 

$val=round(mt_rand()/mt_getrandmax()*80000000000+1000000000);  
echo "<p>".$bn->sinum($val)." &nbsp;(= {$val})</p>"; 

echo "<p><br/><b>You may also specify a statistical error (instead of accuracy)</b></p>";

$bnW = new bnformat\bnformat( ['lang'=>'en-SC'] ); 

$val=mt_rand()/mt_getrandmax()*2000; $u='g'; $err=$val/900; 
echo "<p>".$bnW->sinum($val, $u, ['err'=>$err])." &nbsp;(= {$val} ± {$err} {$u})</p>";

$val=mt_rand()/mt_getrandmax()/10000000; $u='s'; $err=$val/1200; 
echo "<p>".$bnW->sinum($val, $u, ['err'=>$err])." &nbsp;(= {$val} ± {$err} {$u})</p>";


// tnum()

echo "<br/><h3><pre>B. tnum() &ndash; Outputs numbers inside running text (0..12 will be written-out) - text number</pre></h3>";

// outputs 0..12 written-out, all others as digits (as common practice in publications)
echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(2, 15); 
    echo "There are ".$bn->tnum($val)." trees on the hill.<br/>"; 
}
echo "</p>"; 


// tnum() - full use

echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(0, 3); 
    echo $bn->tnum($val, ['trees', 'one tree'], ['transform'=>'ucfirst'])." I see standing at the wayside.<br/>"; 
}
echo "</p>"; 

echo "<p><b>Also rounds big numbers to given accuracy (2 digits):</b></p>";

echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(100, 2000000); 
    echo "ca. ".$bn->tnum($val, ['homes', 'one home'])." &nbsp;(= {$val} homes)<br/>"; 
}
echo "</p>"; 

/*
echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(1, 2000000)/90000000;  
    echo "ca. ".$bn->tnum($val, ['homes', 'one home'])." &nbsp;(= {$val} homes)<br/>"; 
}
echo "</p>"; 
*/


// tsyn() - additionally use of 

echo "<br/><h3><pre>C. tsyn() &ndash; Distinguishes between singular und plural - text syntax</pre></h3>";

echo "<p>"; 
for ($i=0;$i<3;$i++) {
    $val=mt_rand(1, 3); 
    echo $bn->tsyn($val, ['Do', 'Does'])." ".$bn->tnum($val, ['trees', 'a tree'])." stand in the market square?<br/>"; 
}
echo "</p>"; 



echo "<br/>&nbsp;<br/>";


?>
