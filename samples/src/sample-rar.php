<?php

use SystemUtil\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/002-sample.rar';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->filter('*.txt');

foreach ($list as $name=> $entry){
  var_dump([$name, $entry->content()]);
}

