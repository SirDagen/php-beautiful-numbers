# php-beautiful-numbers

## 0. __construct ##

*php-beautiful-numbers* is a rather small number format class (< 15 kB with annotations). It handles numbers in a way that it outputs pretty, easy human readable numbers. 

When initialising you specify at least the tongue you want to use it in, and maybe further options like accuracy (see quick manual inside class file).  

```php
$bn = new bnformat\bnformat( ['lang'=>'de'] ); // set output to German (number format and language) 
```


## 1. sinum() – SI numbers ##

Not only in the physics department it is good practice to use the [SI format](https://en.wikipedia.org/wiki/International_System_of_Units) for writing down any number (in particular very large or small numbers). This ensures easy readability (thanks to the SI prefixes n, µ, m, k, M, G, ...) and only produces an output as precise as necessary (usually 3 digits are the sweet spot, meaning the total number of [significant figures](https://en.wikipedia.org/wiki/Significant_figures)). 

```html
420 k  (= 419532) // korrekt gerundet, 3 Stellen Genauigkeit
73,7 M  (= 73672048.352987) // dito
98,4 µs  (= 9.8437291615846E-5 Sekunde) // mit Einheit und Prefix
695 KiB  (= 711372 Byte) // mit Binärprefix
3,7 km  (= 3657.3480260881 Meter) // Genauigkeit 2 Stellen
```
```html
420 k  (= 419532) // properly rounded, 3 digits accuracy
73.7 M  (= 73672048.352987) // same
98.4 µs  (= 9.8437291615846E-5 second) // with unit and prefix
695 KiB  (= 711372 byte) // using binary prefix
3.7 km  (= 3657.3480260881 meter) // accuracy 2 digits
```

Code looks like this:

```php
echo $bn->sinum( 419532 ); // simple number without unit
echo $bn->sinum( 9.8437291615846E-5, 's' ); // with unit
echo $bn->sinum( 711372, 'B', ['bin'=>true] ); // use binary prefixes 
echo $bn->sinum( 3657.3480260881, 'm', ['acc'=>2] ); // accuracy = 2 digits 
```

If you use HTML mode each space before the unit/prefix gets replaced by a [thin space](https://en.wikipedia.org/wiki/Thin_space). Also (if not disabled) any ambiguous [significant zero](https://en.wikipedia.org/wiki/Significant_figures#Identifying_significant_figures) automatically gets overlined to show the given precision.

## 2.1. tnum() – text numbers ##

In newspapers and other running text it is common practice to note the numbers from 0 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. - Also this function automatically rounds to a given accuracy when you want to display large numbers. 

```html
Ich sehe neun Bäume auf dem Hügel.   (=9)
Ich sehe einen Baum auf dem Hügel.   (=1)
Ich sehe 120.000 Bäume auf dem Hügel.   (=122823) [Genauigkeit: 2 Stellen]
``` 
```html
I see nine trees on the hill.   (=9)
I see a tree on the hill.   (=1)
I see 120,000 trees on the hill.   (=122823) [accuracy: 2 digits]
```

Code looks like this:

```php
echo "I see " . $bn->tnum( $val ) . " trees on the hill."; // quick and easy 
echo "I see " . $bn->tnum( $val, ['trees','a tree'] ) . " on the hill."; // singular distinction
```

*Ann.: The language element is an array so that it is easier to use the class in multi-language surroundings, e.g. tnum($val, $LANG['de']['termin-AKK']) for the German accusative form ["Termine", "einen Termin"] and tnum($val, $LANG['de']['termin-NOM']) for the nominative ["Termine", "ein Termin"].*

## 2.2. tsyn() – text syntax ##

If you want the perfect use of numbers in running text, you might additionally need tsyn() to distinguish between singular and plural for the correlated verb (e.g. "stand" vs. "stands"). 

```html
Ein Baum steht auf dem Marktplatz.   (automatische Großschreibung)
Zwei Bäume stehen auf dem Marktplatz.
15 Bäume stehen auf dem Marktplatz.
```
```html
One tree stands in the market square.   (automatic upper case)
Two trees stand in the market square.
15 trees stand in the market square.
``` 

Code looks like this:

```php
echo $bn->tnum( $val, ['trees','one tree'], ['transform'=>'ucfirst'] ) // first char to uppercase  
    . " " . $bn->tsyn( $val, ['stand','stands'] ) // choose corresponding syntax
    . " in the market square.";

```

## 3. sinum() – statistical usage ##

For statistical usage you may want to use sinum() with a margin of error (or a tolerance) instead of an accuracy:

```html
58,97 ± 0,05 ns  (= 5.8969191908356E-8 ± 4.9140993256964E-11 s) // Deutsches Format
1778 ± 2 mg  (= 1.7781990197386 ± 0.0019757766885984 g) 
```
```html
58.97 ± 0.05 ns  (= 5.8969191908356E-8 ± 4.9140993256964E-11 s) // English format
1778 ± 2 mg  (= 1.7781990197386 ± 0.0019757766885984 g)
```

Code looks like this:

```php
echo $bn->sinum( 1.7781990197386, 'g', ['err'=>0.0019757766885984] ); // error instead of accuracy
```


Have fun!
