# php-beautiful-numbers

## 0. __construct ##

php-beautiful-numbers works with multiple languages. When you call the constructor, you can state the tongue you want to use as well as other options like the accuracy e.g. (see manual in class file).  

```php
$bn = new bnformat\bnformat( ['lang'=>'de'] ); // choose German output
```


## 1. sinum() ##

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


## 2. tnum() ##

In newspapers and other running text it is common practice to note the numbers from 1 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. 

```php
echo "There are ".$bn->tnum(9)." trees on the hill.";
echo "There are ".$bn->tnum(14)." trees on the hill.";
    
```

The output looks like this (Deutsch, English):

```html
Es sind neun Bäume auf dem Hügel.
Es sind 14 Bäume auf dem Hügel.
``` 
```html
There are nine trees on the hill.
There are 14 trees on the hill.
```
