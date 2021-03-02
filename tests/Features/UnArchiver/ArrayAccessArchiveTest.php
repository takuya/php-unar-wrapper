<?php


namespace Tests\Features\UnArchiver;
use Tests\TestCase;
use SystemUtil\Archiver\UnArchiver;


class ArrayAccessArchiveTest extends  TestCase {
  
  public function test_arrayaccess_foreach_filename_with_content(){
    $sample_zip = __DIR__.'/unarchiver-test-data/001-sample.zip';
    $ar = new UnArchiver();
    $ar->open($sample_zip);
  
    foreach ( $ar->filter('*.txt') as $i=> $e ) {
      $this->assertStringContainsString(trim($e->getContent()),$i);
    }
    $list = $ar->filter('*.txt');
    $ret = $list['sample/001.txt'];
    $this->assertStringContainsString('001', $ret);
    
    $ret = isset($list['sample/001.txt']);
    $this->assertTrue($ret);
    
  }
}