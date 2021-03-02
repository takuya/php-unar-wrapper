<?php

$list = glob(__DIR__.'/./src/*.php');
$list = array_diff($list, [__FILE__]);

foreach ($list as $name){
  
  $basename = basename($name);
  $title = str_replace('.php','',$basename);
  $title = str_replace('_', ' ' ,$title);
  $title = ucfirst($title);
  
  echo "## {$title}\n";
  $body = file_get_contents($name);
  $body = trim($body);
  echo "\n";
  echo '```php'."\n";
  echo $body."\n";
  echo '```'."\n";
  
  
}