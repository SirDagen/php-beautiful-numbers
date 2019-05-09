# php-format-functions

## 1. sinum() ##

When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary (usually 3 digits are the sweet spot). Maybe you like this, too. 

```php
$zformat = new PHPzformat\zformat( ['lang'=>'en'] ); // English number format

$val=mt_rand(5, 1999999); 
echo $zformat->sinum($val, 'B', ['bin'=>true]) . "<br/>"; // set to binary instead of SI prefixes
 
$val=mt_rand()/mt_getrandmax()*9000; 
echo $zformat->sinum($val, 'm', ['acc'=>2]) . "<br/>"; // accuracy = 2 digits 
 
$val=mt_rand()/mt_getrandmax()/1000; 
echo $zformat->sinum($val, 's')." (= {$val})<br/>"; 
```

The output might look like this:

```html
695 KiB  (= 711372) [Byte, binary conversion]

3.7 km  (= 3657.3480260881) [meter, 2 digits]

98.4 µs  (= 9.8437291615846E-5) [second]
```


## 2. outnum() ##

In publications it is common practice to write numbers from 1..12 written-out. All others as digits. So I created a function that does exactly that.

```php
$zformat = new PHPzformat\zformat( ['lang'=>'en'] ); // English number format

$val=mt_rand(2, 15); 
echo "There are ".$zformat->outnum($val)." trees on the hill.<br/>";
$val=mt_rand(2, 15); 
echo "There are ".$zformat->outnum($val)." trees on the hill.<br/>";
    
```

The output might look like this:

```html
There are nine trees on the hill.
There are 14 trees on the hill.
```
 
