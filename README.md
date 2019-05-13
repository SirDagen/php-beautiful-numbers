# php-beautiful-numbers

## 0. __construct ##

php-beautiful-numbers works with multiple languages. When you call the constructor, you can state the tongue you want to use as well as other options like the accuracy e.g. (see manual in class file).  

```php
$bn = new bnformat\bnformat( ['lang'=>'de'] ); // set output to German 
```


## 1. sinum() – SI number ##

Not only in the physics department it is good practice to use the SI format for writing down any number (large or small in particular). This ensures easy readability and only makes the output as precise as necessary (usually 3 digits are the sweet spot).  

```php
echo $bn->sinum( 3657.3480260881, 'm', ['acc'=>2] ); // accuracy = 2 digits 
echo $bn->sinum( 9.8437291615846E-5, 's'); // use standard accuracy (= 3 digits)
echo $bn->sinum( 711372, 'B', ['bin'=>true] ); // use binary conversion (instead of SI prefixes) 
```

The output looks like this (Deutsch, English):

```html
3,7 km   = 3657.3480260881 [Meter, Genauigkeit 2 Stellen]
98,4 µs   = 9.8437291615846E-5 [Sekunde]
695 KiB   = 711372 [Byte, Deutsch, Binärsystem]
```
```html
3.7 km   = 3657.3480260881 [meter, acc = 2 digits]
98.4 µs   = 9.8437291615846E-5 [second]
695 KiB   = 711372 [byte, English, use binary conversion]
```


## 2.1. tnum() – text number ##

In newspapers and other running text it is common practice to note the numbers from 0 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. 

```php
echo "I see " . $bn->tnum( $val ) . " trees on the hill."; // easy mode
echo "I see " . $bn->tnum( $val, 'trees', 'a tree' ) . " on the hill."; // singular exception
```

The output looks like this (Deutsch, English):

```html
Ich sehe neun Bäume auf dem Hügel.
Ich sehe 14 Bäume auf dem Hügel.
Ich sehe zwei Bäume auf dem Hügel.
``` 
```html
I see nine trees on the hill.
I see 14 trees on the hill.
I see two trees on the hill.
```


## 2.2. tchoice() – text choice ##

If you want the perfect use of numbers in running text, you might additionally need tchoice() to distinguish between singular and plural for the verb of the sentence (e.g. "do" vs. "does"). 

```php
echo $bn->tnum( $val, 'trees', 'a tree', ['transform'=>'ucfirst']) . " " // e.g. Three trees 
    . $bn->tchoice( $val, 'stand', 'stands') // e.g. stand
    . " in the market square.";

```

The output looks like this (Deutsch, English):

```html
Ein Baum steht auf dem Marktplatz.
Zwei Bäume stehen auf dem Marktplatz.
Drei Bäume stehen auf dem Marktplatz.
```
```html
A tree stands in the market square.
Two trees stand in the market square.
Three trees stand in the market square.
``` 


Have fun!
