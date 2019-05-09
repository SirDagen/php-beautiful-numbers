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

    /*

    --- INIT

    $zformat = new PHPzformat\zformat(['lang'=>'en', 'txt'=>false, 'acc'=>3, 'numberformat'=> ['.', ','] ]);


    --- QUICK MANUAL

    $zformat->sinum(0.00050260131503576, 's'); // outputs numbers in easy to read SI format -> 503 µs
    $zformat->sinum(404436, 'B', ['bin'=>true]); // works also with the binary system -> 395 KiB
    $zformat->sinum(7833.6227931239, 'B', ['acc'=>2]); // works also with the binary system -> 7.8 km (English) OR 7,8 km (German)

    $zformat->outnum(10); // outputs numbers for running text (1..12 will be written-out) -> ten
    $zformat->outnum(42.4956, 2); // 2 decimal places -> 42.50 (this is basically the number_format function)
    $zformat->outnum(41342.4956, -2); // 2 decimal places -> 42.50

    */

    var $presets=['lang'=>'de', 'txt'=>false, 'acc'=>3, 'numberformat'=> [',', '.'] ]; // presets - They can be overwriten with the constructor

    // SI and binary prefixes (binary prefixes below 0 make no sense '?')
    // https://en.wikipedia.org/wiki/International_System_of_Units
    var $siprefix=array( // SI decimal, IEC binary
        -8=>['y', '??'], // yocto
        -7=>['z', '??'], // zepto
        -6=>['a', '??'], // atto
        -5=>['f', '??'], // femto
        -4=>['p', '??'], // pico
        -3=>['n', '??'], // nano
        -2=>['µ', '??'], // micro
        -1=>['m', '??'], // milli
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

        
    
    // numbers 1..12 are usually written-out in publications 
    var $numwords=array(
        'de'=> [ 'null', 'ein/e/m', 'zwei', 'drei', 'vier', 'fünf', 'sechs', 'sieben', 'acht', 'neun',
                'zehn', 'elf', 'zwölf', 'minusword'=>'minus', 'langname'=>'Deutsch', 
                // std number format for this language, can be overwritten in preset['numberformat'] 
                'numberformat'=> [',', '.'], // dec_point, thousands_sep 
            ],
        'en'=> [ 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
                'ten', 'eleven', 'twelve', 'minusword'=>'minus', 'langname'=>'English', 
                // std number format for this language, can be overwritten in preset['numberformat'] 
                'numberformat'=> ['.', ','], // dec_point, thousands_sep 
            ],
    );

    function __construct($presets=false) { // array() 
        if (is_array($presets)) foreach ($presets as $k0=>$v0) $this->presets[$k0] = $v0; // overwrite presets (if stated)
        // if numberformat is not explicitly set (presets['numberformat']), get numberformat from language (presets['lang']) 
        if (!is_array($this->presets['numberformat'])) $this->presets['numberformat']=$this->numwords[$this->presets['lang']]['numberformat'];
    }


    function langname() {
        return $this->numwords[$this->presets['lang']]['langname']; // "Deutsch"
    }


    function _out_val($val, $pdp=0, $md=[]) { // post decimal places (99 = all)
        // outputs numbers in local number format (with stated decimal places)
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        if ($val===false) {
            if ($txt) return '-';
            return '&ndash;';
        }
        if ($pdp==99) {
            $pdp=0; $q=$val;
            while ($q!=floor($q)) { $q*=10; $pdp++; }
        }
        if ($pdp<0) { // force rounding when there are more digits before the decimal point than the given accuracy
            $a=pow(10, -(int)$pdp); $val=round($val/$a)*$a; 
        }
        return number_format($val, $pdp, $this->presets['numberformat'][0], $this->presets['numberformat'][1]); 
    }
 

    function sinum($val, $unit='B', $md=[]) { 
        // outs values with SI: "3240g" -> "3.24 kg"
        // https://en.wikipedia.org/wiki/International_System_of_Units
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=$md[$t]; else $$t=false; // use IEC binary (1024) instead of SI (1000)
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['acc']; // accuracy (decimal digits) - preset = 3
        if ($bin===true) { $a=1024; $ptype=1; } else { $a=1000; $ptype=0; }
        $pow=0;
        if (!empty($val)) {
            while (abs($val)<1) { $val*=$a; $pow--; }
            while (abs($val)>$a) { $val/=$a; $pow++; }
        }
        $acc-=strlen(floor(abs($val))); //if ($acc<0) $acc=0; // only positive values supported right now
        $prefix=$this->siprefix[$pow][$ptype];
        if (empty($unit) and empty($prefix)) $sp='';
        else {
            if ($txt) $sp=' '; else $sp='&#8239;'; // = &thinsp;
        }
        $rt=$this->_out_val($val, $acc, $md).$sp.$prefix.$unit;
        return $rt;
    }

    
    function ucfirst($txt) {
        if (empty($txt)) return $txt;
        return mb_strtoupper(mb_substr($tx, 0, 1)).mb_substr($tx, 1);
        }
            
    function lcfirst($txt) {
        if (empty($txt)) return $txt;
        return mb_strtolower(mb_substr($tx, 0, 1)).mb_substr($txt, 1); 
        }
    
        
    function outnum($val, $pdp=0, $md=[]) { // pdp = post decimal places (99 = all)
        // writes integer numbers 1..12 written-out. all others as digits
        $t='lang'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['lang']; // language
        $t='charmod'; if (!isset($md[$t])) $$t=false; else $$t=$md[$t]; // apply: ucfirst OR toupper
        if ($pdp!=0) return $this->_out_val($val, $pdp, $md);
        $val=round($val); 
        if (abs($val)>12) return $this->_out_val($val, $pdp, $lang);
        if ($val<0) {
            $rt=$this->numwords[$lang]['minusword'].' ';
            $val=-$val;
            }
        else $rt='';
        $rt.=$this->numwords[$lang][$val];
        if (!empty($charmod)) {
            switch($charmod) {
                case 'ucfirst':
                    $rt=$this->ucfirst($rt);
                    break;
                case 'toupper':
                    $rt=mb_strtoupper($rt);
                    break;
                }
            }
        return $rt;
        }



} // end of class

?>
