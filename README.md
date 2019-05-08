# php-format-functions
When studying physics we learned how to correctly output large and small numbers that they are still readable and are only as precise as necessary. Maybe you like this, too.

I start with only one function "sinum".

```php
$zformat = new PHPzformat\zformat(['.', ',']); // English number format

$q=mt_rand(5, 1999999); $u='B'; 
echo "<p>".$zformat->sinum($q, $u, ['bin'=>true])." &nbsp;(= {$q} {$u})</p>"; // set to binary instead of si prefices
 
$q=mt_rand()/mt_getrandmax()*9000; $u='m'; 
echo "<p>".$zformat->sinum($q, $u, ['acc'=>4])." &nbsp;(= {$q} {$u})</p>"; // accuracy is set to 4 decimal digits
```
