<?php
/*
 * bnformat     php-beautiful-numbers class.
 * Version      -see below-
 *
 * @see         https://github.com/SirDagen/php-beautiful-numbers
 *
 * @author      Gordon Axmann
 * @note        This program is licensed under the GNU General Public License v3.0
 *              Copyright and license notices must be preserved. See details at:
 *              https://github.com/SirDagen/php-beautiful-numbers/blob/master/LICENSE 
 */

namespace bnformat;

/*
 * Name         php-beautiful-numbers class (number format functions)
 * Version      1.0.18
 * @author      Gordon Axmann
 */

class bnformat {

    /*

    --- INIT

    $bn = new bnformat\bnformat([ 'lang'=>'en', 'txt'=>false, 'acc'=>3, 'numberformat'=> ['.', ','] ]); // if you state the language, the number format will be set automatically accordingly 


    --- QUICK MANUAL

    $bn->sinum( 7833.6227931239, 'm', ['acc'=>2] ); // works with multiple languages, accuracy, number formats, ... // = 7.8 km (English) -OR- 7,8 km (German)
    $bn->sinum( 0.00050260131503576, 's' ); // outputs numbers in easy to read SI prefix format // = 503 µs
    $bn->sinum( 404436, 'B', ['bin'=>true] ); // sinum() also works with the binary system // = 395 KiB
    
    $bn->tnum( 9 ); // outputs numbers for running text (0..12 will be written-out) // = nine
    $bn->tnum( 5, ['Bäume', 'einem Baum'] ); // you can also make tnum() choose between the plural and the singular word
    
    $bn->tsyn( 5, ['stehen', 'steht'] ); // for the perfect use of numbers in running text you might have to use tsyn() to select the corresponding syntax of the verb (see demo file)
    
    */

    // all presets can be overwriten when using the constructor // $bn = new bnformat\bnformat([ 'lang'=>'en' ); 
    var $presets=['lang'=>'de', 'txt'=>false, 'acc'=>3, 'numberformat'=> [',', '.'] ]; 

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

        
    
    // numbers 0..12 are usually written-out in publications/running text 
    // local number format: https://en.wikipedia.org/wiki/Decimal_separator#Examples_of_use
    // if you need a different number format you can specify it in the __constructor via: 
    // [ 'lang'=>'en', 'numberformat'=> ['·', ' '] ] // en-SI
    // [ 'lang'=>'de', 'numberformat'=> ['.', "'"] ] // de-CH
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
        'fr'=> [ 'zéro', 'un/une', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf',
                'dix', 'onze', 'douze', 'minusword'=>'moins', 'langname'=>'français', 
                // std number format for this language, can be overwritten in preset['numberformat'] 
                'numberformat'=> [',', ' '], // dec_point, thousands_sep 
            ],
        'es'=> [ 'cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
            'diez', 'once', 'doce', 'minusword'=>'menos', 'langname'=>'español', 
            // std number format for this language, can be overwritten in preset['numberformat'] 
            'numberformat'=> [',', '.'], // dec_point, thousands_sep 
        ],
    );

    function __construct($presets=false) { // $presets=array() 
        // overwrite presets (if stated)
        if (is_array($presets)) foreach ($presets as $k0=>$v0) $this->presets[$k0] = $v0; 
        // if numberformat is not explicitly set (presets['numberformat']), get numberformat from language (presets['lang']) 
        if (!is_array($presets['numberformat'])) $this->presets['numberformat']=$this->numwords[$this->presets['lang']]['numberformat'];
    }


    function langname() {
        return $this->numwords[$this->presets['lang']]['langname']; // outputs: "Deutsch" 
    }


    function out_val($val, $pdp=0, $md=[]) { // post decimal places (99 = all)
        // outputs numbers in local number format (with stated decimal places) 
        // it is a copy of number_format but with better rounding
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        if ($val===false) {
            if ($tx) return '-';
            return '&ndash;';
        }
        if ($pdp==99) {
            $pdp=0; $q=$val;
            while ($q!=floor($q)) { $q*=10; $pdp++; }
        }
        if ($pdp<0) { // force rounding when there are more digits before the decimal point than the given accuracy
            $val=round($val, $pdp); 
            // $base=pow(10, -(int)$pdp); $val=round($val/$base)*$base; // older version 
        }
        return number_format($val, $pdp, $this->presets['numberformat'][0], $this->presets['numberformat'][1]); 
    }
 

    function sinum($val, $unit='B', $md=[]) { // SI number
        // outs values with SI: "3240g" -> "3.24 kg"
        // https://en.wikipedia.org/wiki/International_System_of_Units
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['txt']; // !dont use HTML entities in output (e.g. &ndash;)
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['acc']; // accuracy (= decimal digits) - preset = 3
        $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=$md[$t]; else $$t=false; // use IEC binary (1024) instead of SI (1000)
        if ($bin===true) { $base=1024; $ptype=1; } else { $base=1000; $ptype=0; }
        // $pow=floor(log($val, $base)); $val/=pow($base, $pow); // dont know what way is faster in average
        $pow=0;
        if (!empty($val)) {
            while (abs($val)<1) { $val*=$base; $pow--; }
            while (abs($val)>$base) { $val/=$base; $pow++; }
        }
        $acc-=strlen(floor(abs($val))); //if ($acc<0) $acc=0; // only positive values supported right now
        $prefix=$this->siprefix[$pow][$ptype];
        if (empty($unit) and empty($prefix)) $sp='';
        else {
            if ($tx) $sp=' '; else $sp='&#8239;'; // = &thinsp;
        }
        $rt=$this->out_val($val, $acc, $md).$sp.$prefix.$unit;
        return $rt;
    }

    
    function ucfirst($tx) { // upper case first letter
        if (empty($tx)) return $tx;
        return mb_strtoupper(mb_substr($tx, 0, 1)).mb_substr($tx, 1);
    }
            
    function lcfirst($tx) { // lower case first letter
        if (empty($tx)) return $tx;
        return mb_strtolower(mb_substr($tx, 0, 1)).mb_substr($tx, 1); 
    }
    
        
    function tnum($val, $syntax=false, $md=[]) {  // text number // $syntax = array('plural', 'full_singular')
        // writes integer numbers 0..12 written-out. all others as round digits (for running text)
        // you can use it to distinguish between singular and plural. PLEASE NOTE, that you have to offer the FULL SINGULAR, e.g. "one tree" or "a tree" (!) 
        // the standard accuracy for tnum is 2
        if (($syntax!==false) and !is_array($syntax)) echo "***?ERROR-1 tnum()*** ";
        if (is_array($syntax) and !array_key_exists(0, $syntax)) echo "***?ERROR-2 tnum()*** ";
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=2; // accuracy (= decimal digits) 
        $t='pdp'; if (isset($md[$t])) $$t=$md[$t]; else $$t=0; // post decimal places (99 = all) 
        $t='lang'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets['lang']; // choose language
        $t='transform'; if (!isset($md[$t])) $$t=false; else $$t=$md[$t]; // apply (ucfirst OR toupper) to written-out number
        $base=1000; 
        // >12 or fractional  
        if (($pdp!=0) or (abs($val)>12) or ((abs($val)<0.995) and (abs($val)>0))) {
            if ($pdp!=0) $rt=$this->out_val($val, $pdp, $md);
            else {
                $pow=0; $a=$val;
                if (!empty($val)) {
                    while (abs($a)<1) { $a*=$base; $pow--; }
                }
                //$pow2=floor(log($val, 10)); // doesnt work
                $acc-=strlen(floor(abs($a)))+3*$pow; //if ($acc<0) $acc=0; // only positive values supported right now
                if (($acc>0) and (abs($val)>=10)) $acc=0; // dont show e.g. "15.0 trees"
                $rt=$this->out_val($val, $acc, $md);
            }
            if (is_array($syntax)) $rt.=' '.$syntax[0]; 
        }
        // 0..12
        else {
            $val=round($val); 
            // number as word
            $rt=$this->numwords[$lang][abs($val)];
            // add object text
            if (is_array($syntax)) {
                if (abs($val)==1) $rt=$syntax[1];
                else $rt.=' '.$syntax[0];
            }
            if ($val<0) {
                $rt=$this->numwords[$lang]['minusword'].' '.$rt;
                $val=-$val; 
                }
            if (!empty($transform)) {
                switch($transform) {
                    case 'ucfirst':
                    $rt=$this->ucfirst($rt);
                    break;

                    case 'upper': 
                    $rt=mb_strtoupper($rt);
                    break;
                }
            }
        }
        return $rt;
    }

function tsyn($val, $syntax, $md=[]) { // text syntax // $syntax = array('plural', 'singular')
    // chooses between the use of plural or singular
    if (!is_array($syntax)) echo "***?ERROR-1 tsyn()*** ";
    if (is_array($syntax) and !array_key_exists(0, $syntax)) echo "***?ERROR-2 tsyn()*** ";
    $t='transform'; if (!isset($md[$t])) $$t=false; else $$t=$md[$t]; // apply (ucfirst OR toupper) to written-out number
    $val=round($val); 
    if (abs($val)==1) $rt=$syntax[1];
    else $rt=$syntax[0];
    if (!empty($transform)) {
        switch($transform) {
            case 'ucfirst':
            $rt=$this->ucfirst($rt);
            break;

            case 'upper':
            $rt=mb_strtoupper($rt);
            break;
        }
    }
    return $rt; 
}



} // end of class

?>
