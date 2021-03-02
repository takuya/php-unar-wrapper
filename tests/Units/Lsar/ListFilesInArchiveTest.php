<?php


namespace Tests\Units\Lsar;


use Tests\TestCase;
use SystemUtil\Archiver\LsarCommand;


class ListFilesInArchiveTest  extends  TestCase{
  
  public function test_get_list_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::list($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
  }
  public function test_get_list_json_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::list_json($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
    $this->assertArrayHasKey('lsarFormatVersion',json_decode($ret[1],true));
    $this->assertArrayHasKey('lsarContents',json_decode($ret[1],true));
  }
  public function test_get_list_long_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::list_long($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
    $this->assertStringContainsString('Flags  File size   Ratio  Mode  Date       Time   Name', $ret[1]);
    $this->assertStringContainsString('Flags: D=Directory, R=Resource fork, L=Link, E=Encrypted, @=Extended attributes', $ret[1]);
  }
  public function test_get_list_verylong_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::list_verylong($correct_zip);
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
    $this->assertStringContainsString('Compressed size', $ret[1]);
  }
  

  
}