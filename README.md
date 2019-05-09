# php-format-functions
When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary (usually 3 digits are the sweet spot). Maybe you like this, too. 

I start with only one function "sinum".

```php
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

$val=mt_rand(5, 1999999); 
echo $zformat->sinum($val, 'B', ['bin'=>true]) . "<br/>"; // set to binary instead of SI prefixes
 
$val=mt_rand()/mt_getrandmax()*9000; 
echo $zformat->sinum($val, 'm', ['acc'=>2]) . "<br/>"; // accuracy = 2 digits 
 
$val=mt_rand()/mt_getrandmax()/1000; 
echo $zformat->sinum($val, 's')." (= {$val})<br/>"; 
```

The output might look like this:

```html
695 KiB  (= 711372) [Byte]

3.7 km  (= 3657.3480260881) [meter]

98.4 µs  (= 9.8437291615846E-5) [second]
```

