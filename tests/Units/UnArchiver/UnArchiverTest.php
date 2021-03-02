<?php


namespace Tests\Units\UnArchiver;


use Tests\TestCase;
use SystemUtil\Archiver\UnArchiver;


class UnArchiverTest  extends  TestCase {
  
  public function test_unarchiver_class_basic_functions(){
    $sample_zip = __DIR__.'/unarchiver-test-data/001-sample-img.zip';
    // open no exists file
    try{
      $ar = new UnArchiver();
      $ar->open('/no/exist/file');
    }catch ( \Exception $e){
      $this->assertEquals('RuntimeException', get_class($e));
      $this->assertStringContainsString('exist',$e->getMessage());
    }
    // open unreaable file
    try{
      $ar = new UnArchiver();
      $ar->open('/etc/shadow');
    }catch ( \Exception $e){
      $this->assertEquals('RuntimeException', get_class($e));
      $this->assertStringContainsString('readable',$e->getMessage());
    }
    // call methods , before open() called.
    try{
      $ar = new UnArchiver();
      $ar->list();
    }catch ( \Exception $e){
      $this->assertEquals('RuntimeException', get_class($e));
      $this->assertStringContainsString('first',$e->getMessage());
    }
    // get contents.
    try{
      $no_exception=0;
      $ar = new UnArchiver();
      $ar->open($sample_zip);
      $ar->list();
      $data = $ar->getFileContentAt(0);
      $hash = md5($data);
      $this->assertEquals('e17f6bd9e897e25a2441f0dbd7df3f32',$hash);
      

    }catch ( \Exception $e){
      $no_exception = 1;
    }
    $this->assertEquals(0,$no_exception);
    
  
  }
  public function test_unarchiver_glob_functions(){
    $sample_zip = __DIR__.'/unarchiver-test-data/002-glob.zip';
    $ar = new UnArchiver();
    $ar->open($sample_zip);
    //simple glob
    $ret = $ar->list('*.jpg');
    $this->assertGreaterThan(0, count(array_filter($ret, function($e){ return fnmatch('*.jpg',$e);})));
    /// glob filter as array
    $ret = $ar->list(['*.jpg', '*.JPG']);
    $this->assertGreaterThan(0, count(array_filter($ret, function($e){ return fnmatch('*.JPG',$e);})));
    $this->assertGreaterThan(0, count(array_filter($ret, function($e){ return fnmatch('*.jpg',$e);})));
    /// glob filter as array
    $ret = $ar->list(['*.jpg','*.JPG','*.jpeg','*.JPEG']);
    $this->assertGreaterThan(0, count(array_filter($ret, function($e){ return fnmatch('*.jpeg',$e);})));
    $this->assertGreaterThan(0, count(array_filter($ret, function($e){ return fnmatch('*.jpg',$e);})));
    //
    // get file with glob
    $data = $ar->getFileContentAt(0, '*.jpg');
    $hash = md5($data);
    $this->assertEquals('626fb72174969091affac36424ac27d0',$hash);
    $data = $ar->getFileContentAt(1, '*.jpg');
    $hash = md5($data);
    $this->assertEquals('e17f6bd9e897e25a2441f0dbd7df3f32',$hash);
  
  }
  
  public function test_unarchiver_extract_spaced_name_file() {
    $sample_zip = __DIR__.'/unarchiver-test-data/002-glob.zip';
    $f_name = 'a/png/Screenshot 2021-02-19 144351.png';
    $hash = 'ee6cf1ecdcf4d2a16be48f244922d8da';
    //
    $ar = new UnArchiver();
    $ar->open($sample_zip);
    $ret = $ar->getFileContentByFileName($f_name);
    $this->assertEquals($hash,md5($ret));
  
  }

  
}