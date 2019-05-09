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
 * Version 1.0.3
 * @author    SirDagen
 */

class zformat {

    // SI and binary prefixes (binary prefixes below 0 make no sense '?')
    // https://en.wikipedia.org/wiki/International_System_of_Units
    var $siprefix=array( // SI decimal, IEC binary
        -8=>['y', '?'], // yocto
        -7=>['z', '?'], // zepto
        -6=>['a', '?'], // atto
        -5=>['f', '?'], // femto
        -4=>['p', '?'], // pico
        -3=>['n', '?'], // nano
        -2=>['µ', '?'], // micro
        -1=>['m', '?'], // milli
         0=>['', ''],
         1=>['k', 'Ki'], // kilo, ("Ki") <- big K, sic(!)
         2=>['M', 'Mi'], // mega
         3=>['G', 'Gi'], // giga
         4=>['T', 'Ti'], // tera
         5=>['P', 'Pi'], // peta
         6=>['E', 'Ei'], // exa
         7=>['Z', 'Zi'], // zetta
         8=>['Y', 'Yi'], // yotta 
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
        if ($pdp<0) { // force rounding if there are more digits before the point than given accuracy
            $a=pow(10, -$pdp); $val=round($val/$a)*$a; 
        }
        return number_format($val, $pdp, $this->numberformat[0], $this->numberformat[1]); 
    }
 
    // https://en.wikipedia.org/wiki/International_System_of_Units
    public function sinum($val, $unit='B', $md=[]) { 
        // outs values with SI: "3240g" -> "3.24 kg"
        $t='txt'; if (isset($md[$t])) $$t=true; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=true; else $$t=false; // use IEC binary (1024) instead of SI (1000)
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['acc']; // accuracy (decimal digits) - preset = 3
        if ($bin===true) { $a=1024; $ptype=1; } else { $a=1000; $ptype=0; }
        $pow=0;
        if (!empty($val)) {
            while (abs($val)<1) { $val*=$a; $pow--; }
            while (abs($val)>$a) { $val/=$a; $pow++; }
        }
        $acc-=strlen(floor(abs($val))); //if ($acc<0) $acc=0; // only positive values supported right now
        if ($txt) $prefix=' '; else $prefix='&#8239;'; // &thinsp;
        $prefix.=$this->siprefix[$pow][$ptype];
        $rt=$this->out_val($val, $acc, $md).$prefix.$unit;
        return $rt;
    }

}

?>
