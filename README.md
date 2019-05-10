# php-format-functions

## 0. new PHPzformat\zformat() ##

All zformat-functions can be configured for different languages. You just state the language you want to use in the constructor. At the same time you can set the accuracy and the number format (all values are optional and overwrite the preset).  

```php
$zformat = new PHPzformat\zformat([ 'lang'=>'en', 'acc'=>3 ]);
```


## 1. sinum() ##

Not only in the physics department it is good practice to use the SI format for writing down any number (large or small in particular). This ensures easy readability and only makes the output as precise as necessary (usually 3 digits are the sweet spot).  

```php
echo $zformat->sinum(711372, 'B', ['bin'=>true]); // set to binary instead of SI prefixes
echo $zformat->sinum(3657.3480260881, 'm', ['acc'=>2]); // accuracy = 2 digits 
echo $zformat->sinum(9.8437291615846E-5, 's'); 
```

The output looks like this:

```html
695 KiB   = 711372 [byte + binary conversion]
3.7 km   = 3657.3480260881 [meter + 2 digits]
98.4 µs   = 9.8437291615846E-5 [second]
```
```html
695 KiB   = 711372 [Byte + Binärsystem]
3,7 km   = 3657.3480260881 [Meter + 2 Stellen]
98,4 µs   = 9.8437291615846E-5 [Sekunde]
```


## 2. outnum() ##

In running text it is common practice to note the numbers from 1 to 12 written-out; all other numbers are written as digits. This produces more beautiful and easier to read texts. 

```php
echo "There are ".$zformat->outnum(9)." trees on the hill.";
echo "There are ".$zformat->outnum(14)." trees on the hill.";
    
```

The output might look like this:

```html
There are nine trees on the hill.
There are 14 trees on the hill.
```
```html
Es sind neun Bäume auf dem Hügel.
Es sind 14 Bäume auf dem Hügel.
``` 
