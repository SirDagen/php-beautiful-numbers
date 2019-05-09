# php-format-functions
When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary (usually 3 digits are sufficient). Maybe you like this, too.

I start with only one function "sinum".

```php
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

$val=mt_rand(5, 1999999); 
echo $zformat->sinum($val, 'B', ['bin'=>true])." (= {$val})<br/>"; // set to binary instead of si prefices
 
$val=mt_rand()/mt_getrandmax()*9000; 
echo $zformat->sinum($val, 'm', ['acc'=>3])." (= {$val})<br/>"; // accuracy = 3 digits (that is the std value)
 
$val=mt_rand()/mt_getrandmax()/1000; 
echo $zformat->sinum($val, 's')." (= {$val})<br/>"; 
```

The output might look like this:

```html
695 KiB  (= 711372 Byte)

3.66 km  (= 3657.3480260881 meter)

98.4 µs  (= 9.8437291615846E-5 second)
```

