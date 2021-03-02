<?php


namespace Tests\Units\UnArchiver;

use Tests\TestCase;
use SystemUtil\Archiver\UnArchiver;

class UnArchiverEntryTest extends TestCase {

  public function test_unarchiver_entry() {
    $sample_zip = __DIR__.'/unarchiver-test-data/001-sample-img.zip';
  
    $ar = new UnArchiver();
    $ar->open($sample_zip);
    $a = $ar->getEntryAt(0);
    $hash = md5($a->content());
    $this->assertEquals('e17f6bd9e897e25a2441f0dbd7df3f32',$hash);
  
  
    $sample_zip = __DIR__.'/unarchiver-test-data/002-glob.zip';
    $ar = new UnArchiver();
    $ar->open($sample_zip);
    $e = $ar->getEntryAt(0);
    $this->assertTrue($e->isDirectory());
    $e = $ar->getEntryAt(1);
    $this->assertFalse($e->isDirectory());
    $e = $ar->getEntryAt(2);
    $this->assertFalse($e->isDirectory());
    
    //
    $ret = $ar->getEntries();
    $directories = array_filter($ret, function($e){ return $e->isDirectory(); });
    foreach ( $directories as $e ) {
      $this->assertTrue($e->isDirectory());
    }
    $files = array_filter($ret, function($e){ return !$e->isDirectory(); });
    foreach ( $files as $e ) {
      $this->assertFalse($e->isDirectory());
      $this->assertGreaterThan(0,strlen($e->getContent()));
    }
    
  }
}