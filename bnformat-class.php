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
 * Version      1.0.23
 * @author      Gordon Axmann
 */

class bnformat {

    /*

    --- INIT

    $bn = new bnformat\bnformat([ 'lang'=>'en', 'txt'=>false, 'acc'=>3, 'numberformat'=> ['.', ','] ]); // (if you state the language, the number format will be set automatically accordingly) 
    $bn = new bnformat\bnformat([ 'lang'=>'en-SI' ]); // you can also set a sub type of the local language format


    --- QUICK MANUAL

    $bn->sinum( 7833.6227931239, 'm', ['acc'=>2] ); // works with multiple languages, accuracy, number formats, ... // = 7.8 km (English) -OR- 7,8 km (German)
    $bn->sinum( 0.00050260131503576, 's' ); // outputs numbers in easy to read SI prefix format // = 503 µs
    $bn->sinum( 404436, 'B', ['bin'=>true] ); // sinum() also works with the binary system // = 395 KiB
    
    $bn->tnum( 9 ); // outputs numbers for running text (0..12 will be written-out) // = nine
    $bn->tnum( 5, ['Bäume', 'einem Baum'] ); // you can also make tnum() choose between the plural and the singular word
    
    $bn->tsyn( 5, ['stehen', 'steht'] ); // for the perfect use of numbers in running text you might have to use tsyn() to select the corresponding syntax of the verb (see demo file)
    
    */

    // all presets can be overwriten when using the constructor // $bn = new bnformat\bnformat([ 'lang'=>'en' ); 
    var $presets=['lang'=>'de', 'txt'=>false, 'acc'=>3, 'over'=>true, 'numberformat'=> [',', '.'] ]; 
    // (lang)uage - language code: de, en, fr, de-WI, ... 
    // (txt) - Text(=true) or HTML(=false) 
    // (acc)uracy - significant figures https://en.wikipedia.org/wiki/Significant_figures
    // (over)line - overline ambiguous significant zero in HTML
    // (numberformat) - set number format (usually this gets set automatically by choosing the correct language code)

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

        
    
    // numbers 0..12 are usually written-out in publications/running text 
    // the language of the constructor (see INIT) also sets the local number format
    // [ 'lang'=>'de' ] 
    // or by using the subvariants of the language arrays, like "de-CH", which will overwrite the standard 'numberformat' entry set by 'lang'
    // [ 'lang'=>'de-CH' ] // set language to de, language format to the subset "de-CH"
    var $numwords=array(
        'de'=> [ 'null', 'ein/e/m', 'zwei', 'drei', 'vier', 'fünf', 'sechs', 'sieben', 'acht', 'neun',
                'zehn', 'elf', 'zwölf', 'minusword'=>'minus', 'langname'=>'Deutsch', 
                // std number format for this language
                'numberformat'=> [',', '.'], // dec_point, thousands_sep 
            ],
        'en'=> [ 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
                'ten', 'eleven', 'twelve', 'minusword'=>'minus', 'langname'=>'English', 
                // std number format for this language
                'numberformat'=> ['.', ','], // dec_point, thousands_sep 
            ],
        'fr'=> [ 'zéro', 'un/une', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf',
                'dix', 'onze', 'douze', 'minusword'=>'moins', 'langname'=>'français', 
                // std number format for this language
                'numberformat'=> [',', ' '], // dec_point, thousands_sep 
            ],
        'es'=> [ 'cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
                'diez', 'once', 'doce', 'minusword'=>'menos', 'langname'=>'español', 
                // std number format for this language
                'numberformat'=> [',', '.'], // dec_point, thousands_sep 
        ],
    );

    // local sub number formats that differ from the above language array
    // can be accessed by using the extended language code, e.g. "en-SI"
    // if you need yet another number format you can individually specify it in the __constructor via: 
    // [ 'lang'=>'en', 'numberformat'=> ["'", '.'] ] 
    // local number format: https://en.wikipedia.org/wiki/Decimal_separator#Examples_of_use
    var $numformat=array(
        // type => [ dec_point, thousands_sep ]
        'en-SI'=> ['.', ' '], // English-SI style (official English-Canada) 
        'en-MT'=> ['·', ' '], // English-Malta
        'en-SC'=> ['.', ''], // English-scientific 
        'de-LI'=> ['.', "'"], // Deutsch-Liechtenstein  
        'de-WI'=> [',', ''], // Deutsch-Wissenschaftlich 
    );
    
    function __construct($presets=false) { // $presets=array() -- INIT
        // overwrite the class presets (if wanted), e.g. $presets = [ 'lang'=>'en', 'numberformat'=> ['.', ' '], 'acc'=>4 ]
        $numformat=false;
        if (is_array($presets)) {
            if (isset($presets['lang']) and (strpos($presets['lang'], '-')!==false)) { 
                if (array_key_exists($presets['lang'], $this->numformat)) $numformat=$this->numformat[$presets['lang']];
                $lgar=explode('-', $presets['lang']);
                $presets['lang']=$lgar[0]; // only take first part of 'lang', e.g. "en" instead "en-SI" 
            }
            foreach ($presets as $k0=>$v0) $this->presets[$k0] = $v0; 
        }
        // when numberformat is not explicitly stated, get local numberformat from presets['lang']   
        if (!is_array($presets['numberformat'])) {
            if (!empty($numformat)) $this->presets['numberformat']=$numformat; // use a number format from the $numformat[] subset, e.g. "en-SI"
            else $this->presets['numberformat']=$this->numwords[$this->presets['lang']]['numberformat']; // use number format from $numwords[], e.g. "de" 
        }
    }


    function langname() {
        return $this->numwords[$this->presets['lang']]['langname']; // outputs: "Deutsch" 
    }


    function out_val($val, $pdp=0, $md=[]) { // post decimal places (99 = all)
        // outputs numbers in local number format (with stated decimal places) 
        // it is a copy of number_format but with better rounding
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets[$t]; // !dont use HTML entities in output (e.g. &ndash;)
        $t='over'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets[$t]; 
        if ($val===false) {
            if ($txt) return '-';
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
        $rt=number_format($val, $pdp, $this->presets['numberformat'][0], $this->presets['numberformat'][1]); 
        // if a ambiguous significant zero exists, mark it in HTML
        // https://en.wikipedia.org/wiki/Significant_figures#Identifying_significant_figures
        if ($over and !$txt and ($pdp<=0)) {
            $i=strlen($rt)-1; $p=0;
            while ($p>$pdp) { 
                if (is_numeric(substr($rt, $i, 1))) $p--;
                $i--; 
            } 
            if (substr($rt, $i, 1)=='0') $rt=substr($rt, 0, $i)."<span style='text-decoration:overline;'>0</span>".substr($rt, $i+1); // &#773; is ugly
        }
        return $rt;
    }
 

    function sinum($val, $unit='', $md=[]) { // SI number output
        // outs values with SI: "3240g" -> "3.24 kg"
        // https://en.wikipedia.org/wiki/International_System_of_Units
        $t='txt'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets[$t]; // !dont use HTML entities in output (e.g. &ndash;)
        $t='acc'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets[$t]; // accuracy (= decimal digits) - preset = 3
        $t='err'; if (isset($md[$t])) { $$t=$md[$t]; if (!isset($md['over'])) $md['over']=false; } else $$t=0; // use (err)or value instead of (acc)uracy
        $t='bin'; if (isset($md[$t]) and !empty($md[$t])) $$t=$md[$t]; else $$t=false; // use IEC binary (1024) instead of SI (1000)
        if ($bin===true) { $base=1024; $ptype=1; } else { $base=1000; $ptype=0; }
        // $pow=floor(log($val, $base)); $val/=pow($base, $pow); // dont know what way is faster in average
        $pow=0;
        if (!empty($val)) {
            while (abs($val)<1) { $val*=$base; $err*=$base; $pow--; }
            while (abs($val)>1000) { $val/=$base; $err/=$base; $pow++; } // 0,984 MiB is easier to read than 1.010 KiB  
            if (!empty($err)) while (abs($err)<0.0095) { $val*=$base; $err*=$base; $pow--; } // this(!) order of whiles(!)
        }
        $acc-=strlen(floor(abs($val))); //if ($acc<0) $acc=0; // only positive values supported right now
        if (floor(abs($val))==0) $acc++; // add a digit if integer portion is zero (e.g. 0.984 MiB)
        $prefix=$this->siprefix[$pow][$ptype];
        if (empty($unit) and empty($prefix)) $sp='';
        else {
            if ($txt) $sp=' '; else $sp='&#8239;'; // = &thinsp;
        }
        if (empty($err)) $rt=$this->out_val($val, $acc, $md).$sp.$prefix.$unit;
        else {
            $lg=log(abs($err), 10); $frac=($lg<0) ? $lg-ceil($lg) : $lg-floor($lg); // $frac=fmod($lg, 1); is a little slower
            $acc=-floor($lg); 
            if ($frac<0 && $frac>-0.02227639471121) $acc--; // dont display error = 1.0 (substract 1 digit of accuracy, if e.g. 0.99827199496456)
            $rt=$this->out_val($val, $acc, $md).$sp.'±'.$sp;
            $t='over'; $md[$t]=$this->presets[$t]; // sets 'over' to presets
            $rt.=$this->out_val($err, $acc, $md).$sp.$prefix.$unit; 
        }
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
        $t='lang'; if (isset($md[$t])) $$t=$md[$t]; else $$t=$this->presets[$t]; // choose language
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
