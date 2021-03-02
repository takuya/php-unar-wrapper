<?php

use SystemUtil\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
foreach ($ar->list() as $i=>$e){
  $ret = $ar->getFileContentAt($i);
}


