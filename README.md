# php-format-functions

## 1. sinum() ##

Not only in the physics department it is good practice to use the SI format for writing down any number (large or small in particular). This ensures easy readability and only makes the output as precise as necessary (usually 3 digits are the sweet spot).  

```php
$zformat = new PHPzformat\zformat( ['lang'=>'en'] ); // English number format

echo $zformat->sinum(mt_rand(5, 1999999), 'B', ['bin'=>true]); // set to binary instead of SI prefixes
echo $zformat->sinum(mt_rand()/mt_getrandmax()*9000, 'm', ['acc'=>2]); // accuracy = 2 digits 
echo $zformat->sinum(mt_rand()/mt_getrandmax()/1000000, 's'); 
```

The output might look like this:

```html
695 KiB   = 711372 [byte + binary conversion]
3.7 km   = 3657.3480260881 [meter + 2 digits]
98.4 µs   = 9.8437291615846E-5 [second]
```


## 2. outnum() ##

In running text it is common practice to note the numbers from 1 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. 

```php
$zformat = new PHPzformat\zformat( ['lang'=>'en'] ); // English number format

echo "There are ".$zformat->outnum(mt_rand(2, 15))." trees on the hill.";
echo "There are ".$zformat->outnum(mt_rand(2, 15))." trees on the hill.";
    
```

The output might look like this:

```html
There are nine trees on the hill.
There are 14 trees on the hill.
```
 
