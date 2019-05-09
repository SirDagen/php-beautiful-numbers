# php-format-functions
When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary. Maybe you like this, too.

I start with only one function "sinum".

```php
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

$val=mt_rand(5, 1999999); 
echo $zformat->sinum($val, 'B', ['bin'=>true])." (= {$val})<br/>"; // set to binary instead of si prefices
 
$val=mt_rand()/mt_getrandmax()*9000; 
echo $zformat->sinum($val, 'm', ['acc'=>4])." (= {$val})<br/>"; // accuracy is set to 4 decimal digits
```

The output might look like this:

```html
438 KiB  (= 448156)

8.062 km  (= 8062.3298189893)
```

