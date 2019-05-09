<?php
/*
 * PHPzformat - PHP format functions class.
 * Version -see below-
 *
 * @see       https://github.com/SirDagen/php-format-functions
 *
 * @author    SirDagen
 * @note      This program is distributed WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE
 */

 namespace PHPzformat;
/*
 * PHPzformat - PHP format functions class.
 * Version 1.0.2
 * @author    SirDagen
 */

class zformat {

    // si and binary prefixes (binary prefixes below 0 make no sense, but are listed for consistency sake)
    var $siprefix=array( // decimal, binary
        -5=>['f', 'fi'], 
        -4=>['p', 'pi'], 
        -3=>['n', 'ni'], 
        -2=>['µ', 'µi'], // mycro
        -1=>['m', 'mi'], // milli
         0=>['', ''],
         1=>['k', 'Ki'], // kilo 
         2=>['M', 'Mi'], // mega
         3=>['G', 'Gi'], // giga
         4=>['T', 'Ti'],
         5=>['P', 'Pi'],  
        ); 

    var $numberformat=[',', '.']; // dec_point, thousands_sep // here: German number format
    
    var $presets=['txt'=>false, 'acc'=>3]; // presets. can be overwriten with the constructor

    function __construct($numberformat=false, $presets=false) { // array(dec_point, thousands_sep), array()
        if ($numberformat!==false) $this->numberformat = $numberformat;
        if ($presets!==false) $this->presets = $presets;
    }

    public function out_val($val, $pdp=0, $md=[]) { // number, post decimal places (-99 = all)
        // outputs values in local number format (with given decimal places)
        $t='txt'; if (isset($md[$t])) $$t=true; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        if ($val===false) {
            if ($txt) return '-';
            return '&ndash;';
        }
        if ($pdp==-99) {
            $pdp=0; $q=$val;
            while ($q!=floor($q)) { $q*=10; $pdp++; }
        }
        return number_format($val, $pdp, $this->numberformat[0], $this->numberformat[1]); 
    }
 
    public function sinum($val, $unit='B', $md=[]) { 
        // outs values with si: "3240g" -> "3.24 kg"
        $t='txt'; if (isset($md[$t])) $$t=true; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=true; else $$t=false; // use IEC binary (1024) instead of SI (1000)
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['acc']; // accuracy (decimal places) - preset = 3
        if ($bin===true) { $a=1024; $stype=1; } else { $a=1000; $stype=0; }
        $pow=0;
        if (!empty($val)) {
            while (abs($val)<1) { $val*=$a; $pow--; }
            while (abs($val)>$a) { $val/=$a; $pow++; }
        }
        $acc-=strlen(floor(abs($val))); if ($acc<0) $acc=0; // only positive values supported right now
        if ($txt) $prefix=' '; else $prefix='&#8239;'; // &thinsp;
        $prefix.=$this->siprefix[$pow][$stype]; 
        $rt=$this->out_val($val, $acc, $md).$prefix.$unit;
        return $rt; 
    }

}

?>
