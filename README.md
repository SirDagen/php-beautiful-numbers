# php-format-functions
When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary. Maybe you like this, too.

I start with only one function "sinum".

```php
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

$q=mt_rand(5, 1999999); $u='B'; 
echo $zformat->sinum($q, $u, ['bin'=>true])." (= {$q} {$u})<br/>"; // set to binary instead of si prefices
 
$q=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo $zformat->sinum($q, $u, ['acc'=>4])." (= {$q} {$u})<br/>"; // accuracy is set to 4 decimal digits
```

This outputs:

```html
1.20 MiB  (= 1257004 B)

8.444 km  (= 8443.6195392365 m)
```

