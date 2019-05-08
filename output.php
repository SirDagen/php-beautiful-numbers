<?php

#
# --- SirDagen PHP format functions
# --- V1.0.1 
#


// si and binary prefixes (binary prefixes below 0 make no sense, but are listed for consistency sake)
$GLOBALS['var_siprefix']=array( // decimal and binary
    -5=>array('f', 'fi'), 
    -4=>array('p', 'pi'), 
    -3=>array('n', 'ni'), 
    -2=>array('µ', 'µi'),
    -1=>array('m', 'mi'), 
    0=>array('', ''),
    1=>array('k', 'Ki'), // kilo 
    2=>array('M', 'Mi'), // mega
    3=>array('G', 'Gi'), // giga
    4=>array('T', 'Ti'),
    5=>array('P', 'Pi'), 
    ); 
    
function out_val($val, $pdp=0, $md=array()) { // post decimal places / -1 = all
    // outputs values in local number format with given decimal places
    $t='txt'; if (isset($md[$t]) and !empty($md[$t])) $$t=true; else $$t=false; // dont use HTML (e.g. &ndash;)
	if ($val===false) {
		if ($txt) return '-';
		return '&ndash;';
	}
	if ($pdp==-1) {
		$i=0; $q=$val;
		while ($q!=floor($q)) { $q*=10; $i++; }
		$pdp=$i; 
	}
	return number_format($val, $pdp, ',', '.'); // e.g. German number format
}

function out_sinum($val, $unit='B', $md=array()) { 
    // outs values with si: "3240g" -> "3.24 kg"
    $t='txt'; if (isset($md[$t]) and !empty($md[$t])) $$t=true; else $$t=false; // dont use HTML in output (e.g. &ndash;)
    $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=true; else $$t=false; // use IEC binary (1024) instead of SI (1000)
    $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=3; // accuracy (decimal places) - preset = 3
	if ($bin===true) { $a=1024; $bin=1; }
	else { $a=1000; $bin=0; }
	$i=0;
	if (!empty($val)) {
        while (abs($val)<1) { $val*=$a; $i--; }
        while (abs($val)>$a) { $val/=$a; $i++; }
	}
	$acc-=strlen(floor(abs($val))); if ($acc<0) $acc=0; 
	if ($txt) $t=' '; else $t='&#8239;'; // &thinsp;
	$t.=$GLOBALS['var_siprefix'][$i][$bin]; 
	$rt=out_val($val, $acc, $md).$t.$unit;
	return $rt;
}




?>
