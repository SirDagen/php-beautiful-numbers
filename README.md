# php-beautiful-numbers

## 0. __construct ##

*php-beautiful-numbers* is a number formatting class that is rather small (with annotations < 15 kB). It handles numbers in a way that produces neat, easily readable output.  

When initialising, you specify at least the language you want to use, and optionally further options such as accuracy (see quick manual inside the class file).   

```php
$bn = new bnformat\bnformat( ['lang'=>'de'] ); // set output to German (number format and language) 
```


## 1. sinum() – SI numbers ##

Not only in physics is it good practice to use the [SI format](https://en.wikipedia.org/wiki/International_System_of_Units) when writing down numbers (especially very large or very small ones). This ensures easy readability (thanks to the SI prefixes n, µ, m, k, M, G, …) and produces output that is only as precise as necessary (usually 3 digits are the sweet spot, meaning the total number of [significant figures](https://en.wikipedia.org/wiki/Significant_figures)). 

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

If you use HTML mode, each space before the unit/prefix is replaced by a [thin space](https://en.wikipedia.org/wiki/Thin_space). Also (if not disabled), any ambiguous [significant zero](https://en.wikipedia.org/wiki/Significant_figures#Identifying_significant_figures) automatically gets an overline to indicate the given precision.

## 2.1. tnum() – text numbers ##

In newspapers and other continuous text, it is common practice to spell out numbers from 0 to 12; all higher numbers are written as digits. This results in more elegant and easier-to-read text. This function also automatically rounds large numbers to the given accuracy.  

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

*Note: The language element is an array so that it is easier to use the class in multi-language contexts — for example, tnum($val, $LANG['de']['termin-AKK']) for the German accusative form ["Termine", "einen Termin"], and tnum($val, $LANG['de']['termin-NOM']) for the nominative ["Termine", "ein Termin"].*

## 2.2. tsyn() – text syntax ##

For perfect grammar when using numbers in continuous text, you might also need tsyn() to distinguish between singular and plural in the related verb (e.g. "stand" vs. "stands").  

```html
Ein Baum steht auf dem Marktplatz.   (automatische Großschreibung am Satzanfang)
Zwei Bäume stehen auf dem Marktplatz.   ("stehen")
15 Bäume stehen auf dem Marktplatz.
```
```html
One tree stands in the market square.   (automatic capitalisation at the start of the sentence)
Two trees stand in the market square.   ("stand")
15 trees stand in the market square.
``` 

Code looks like this:

```php
echo $bn->tnum( $val, ['trees','one tree'], ['transform'=>'ucfirst'] ) // first char to uppercase  
    . " " . $bn->tsyn( $val, ['stand','stands'] ) // choose corresponding syntax
    . " in the market square.";

```

## 3. sinum() – statistical usage ##

For statistical use, you may want to apply sinum() with a margin of error (or tolerance) instead of an accuracy:

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
