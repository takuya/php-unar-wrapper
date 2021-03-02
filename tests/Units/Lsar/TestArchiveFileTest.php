<?php

namespace Tests\Units\Lsar;


use Tests\TestCase;
use SystemUtil\Archiver\LsarCommand;

class TestArchiveFileTest extends TestCase{
  
  public function testZipFileIsCorrect(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::test($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
  }
  public function testZipFileIsCorrupt(){
    $correct_zip = __DIR__.'/lsar-test-data/001-broken-zip.zip';
    $ret = LsarCommand::test($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(1,$ret[0]);
  }
  public function testZipFileLisIsCorrupt(){
    $file_list = [__DIR__.'/lsar-test-data/001-broken-zip.zip',__DIR__.'/lsar-test-data/002-plaintext.zip'];
    $ret = LsarCommand::test(...$file_list);
    $this->assertIsArray($ret);
    $this->assertEquals(1,$ret[0]);
  }
}