# php-unar-wrapper

php Unarchive command line tools wrapper

no compress, only for extract. but many formats can use.

## Why this package written.

To deal in same way several archive formats ( zip/tar/rar ).




## support formats.

depends on `unar` ( Unarvhive command line tool ).

zip / rar(winrar) / tar.gz  works file.


## Installing 

```shell
composer require takuya/php-unar-wrapper
```

## How to use

```php
<?php

require_once 'vendor/autoload.php';

use SystemUtil\Archiver\UnArchiver;

$sample_zip = __DIR__.'/sample.zip';
$ar = new UnArchiver();
$ar->open($sample_zip);
foreach( $ar->list() as $name => $entry ){
  var_dump([$name,$entry->contents()]);
}

?>
```

## requirement

UnArchiver commad line tools.

```shell
sudo apt install unar
```


## More samples. 

See `samples/` in repositry.

