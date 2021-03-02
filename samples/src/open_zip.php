<?php

use SystemUtil\Archiver\UnArchiver;

require_once __DIR__.'/../../vendor/autoload.php';

$sample_zip = __DIR__.'/sample-data/001-sample.zip';

$ar = new UnArchiver();
$ar->open($sample_zip);
$list = $ar->list();
$content = $ar->getFileContentByFileName($list[0]);
var_dump($content);


