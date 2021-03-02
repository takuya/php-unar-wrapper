<?php


namespace Tests\Units\Lsar;


use Tests\TestCase;
use SystemUtil\Archiver\LsarCommand;


class ShowFileInfoInArchiveTest extends TestCase {
  
  public function test_lsar_file_with_filename_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::list($correct_zip, '*.txt');
    $this->assertIsArray($ret);
    $this->assertEquals(0,$ret[0]);
  }
  public function test_lsar_file_exists_filename_in_archive(){
    $correct_zip = __DIR__.'/lsar-test-data/002-plaintext.zip';
    $ret = LsarCommand::file_exists($correct_zip, '*/xyz.txt');
    $this->assertIsBool($ret);
    $this->assertTrue($ret);
    $ret = LsarCommand::file_exists($correct_zip, '*/aaaaaaaaaaaaa.txt');
    $this->assertIsBool($ret);
    $this->assertFalse($ret);
  }
  
}