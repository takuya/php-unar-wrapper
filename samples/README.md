## Access foreach

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
foreach ($ar->list() as $i=>$e){
  $ret = $ar->getFileContentAt($i);
}
```
## Access using entryclass

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->list();
$entry = $ar->getEntryByName($list[0]);

var_dump($entry->content());
```
## Access using index num

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
$conent = $ar->getFileContentAt(0);
var_dump($conent);
```
## Filter filelist

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->filter('*.txt');

foreach ($list as $name=> $entry){
  var_dump([$name, $entry->content()]);
}
```
## Open zip

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->list();
$content = $ar->getFileContentByFileName($list[0]);
var_dump($content);
```
## Sample-rar

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/002-sample.rar';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->filter('*.txt');

foreach ($list as $name=> $entry){
  var_dump([$name, $entry->content()]);
}
```
## Sample-tar

```php
<?php

use Takuya\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/003-sample.tgz';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->filter('*.txt');

foreach ($list as $name=> $entry){
  var_dump([$name, $entry->content()]);
}
```
