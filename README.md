# php-beautiful-numbers

## 0. __construct ##

*php-beautiful-numbers* is a rather small but useful class (< 15 kB with annotations). It handles numbers in a way that the output are pretty, easy human readable numbers. 

When initialising you call the constructor specifying at least the tongue you want to use it in, and maybe further options like accuracy etc. (see quick manual inside class file).  

```php
$bn = new bnformat\bnformat( ['lang'=>'de'] ); // set output to German 
```


## 1. sinum() – SI numbers ##

Not only in the physics department it is good practice to use the [SI format](https://en.wikipedia.org/wiki/International_System_of_Units) for writing down any number (large or small in particular). This ensures easy readability (thanks to the SI prefixes as n, µ, m, k, M, G, ...) and only produces an output as precise as necessary (usually 3 digits are the sweet spot, what means the total number of meaningful digits like 56.9). 

```php
echo $bn->sinum( 73672048 ); // no unit 
echo $bn->sinum( 9.8437291615846E-5, 's' ); // with unit
echo $bn->sinum( 711372, 'B', ['bin'=>true] ); // use binary prefixes 
echo $bn->sinum( 3657.3480260881, 'm', ['acc'=>2] ); // accuracy = 2 digits 
```

Output looks like this (Deutsch, English):

```html
420 k  (= 419532) // korrekt gerundet, 3 Stellen Genauigkeit
73,7 M  (= 73672048) // dito
98,4 µs  (= 9.8437291615846E-5 Sekunde) // mit Einheit und Prefix
695 KiB  (= 711372 Byte) // mit Binärprefix
3,7 km  (= 3657.3480260881 Meter) // Genauigkeit 2 Stellen
```
```html
420 k  (= 419532) // properly rounded, 3 digits accuracy
73.7 M  (= 73672048) // dito
98.4 µs  (= 9.8437291615846E-5 second) // with unit and prefix
695 KiB  (= 711372 byte) // with binary prefix
3.7 km  (= 3657.3480260881 meter) // accuracy 2 digits
```

## 2.1. tnum() – text numbers ##

In newspapers and other running text it is common practice to note the numbers from 0 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. (Additionally this function automatically rounds to a given accuracy when you want to display large numbers.) 

```php
echo "I see " . $bn->tnum( $val ) . " trees on the hill."; // quick and easy 
echo "I see " . $bn->tnum( $val, ['trees', 'one tree'] ) . " on the hill."; // singular distinction
```

Output looks like this (Deutsch, English):

```html
Ich sehe neun Bäume auf dem Hügel.   (=9)
Ich sehe einen Baum auf dem Hügel.   (=1)
Ich sehe 120.000 Bäume auf dem Hügel.   (=122823) [Genauigkeit: 2 Stellen]
``` 
```html
I see nine trees on the hill.   (=9)
I see one tree on the hill.   (=1)
I see 120,000 trees on the hill.   (=122823) [accuracy: 2 digits]
```

*Ann.: We use an array for the language element so that it is easier to use in multi-language websites, e.g. tnum($val, $LANG['de']['termin-AKK']) for the German accusative form ["Termine", "einen Termin"] and tnum($val, $LANG['de']['termin-NOM']) for the nominative ["Termine", "ein Termin"].*

## 2.2. tsyn() – text syntax ##

If you want the perfect use of numbers in running text, you might additionally need tsyn() to distinguish between singular and plural for the correlated verb (e.g. "stand" vs. "stands"). 

```php
echo $bn->tnum( $val, ['trees', 'a tree'], ['transform'=>'ucfirst'] ) . " " // start uppercase  
    . $bn->tsyn( $val, ['stand', 'stands'] ) // corresponding syntax
    . " in the market square.";

```

Output looks like this (Deutsch, English):

```html
Ein Baum steht auf dem Marktplatz.   (automatische Großschreibung)
Zwei Bäume stehen auf dem Marktplatz.
15 Bäume stehen auf dem Marktplatz.
```
```html
A tree stands in the market square.   (automatic upper case)
Two trees stand in the market square.
15 trees stand in the market square.
``` 

## 3. sinum() – statistical use ##

For statistical usage you may replace the accuracy of sinum() with an error value (for a tolerance or its statistical margin of error):

```php
echo $bn->sinum( 845.25110798201, 'g', ['err'=>0.93916789775779] ); // use error instead of accuracy
```

Output looks like this (Deutsch, English):

```html
845,3 ± 0,9 g  (= 845.25110798201 ± 0.93916789775779 g)
58,97 ± 0,05 ns  (= 5.8969191908356E-8 ± 4.9140993256964E-11 s)
```
```html
845.3 ± 0.9 g  (= 845.25110798201 ± 0.93916789775779 g)
58.97 ± 0.05 ns  (= 5.8969191908356E-8 ± 4.9140993256964E-11 s)
```


Have fun!
