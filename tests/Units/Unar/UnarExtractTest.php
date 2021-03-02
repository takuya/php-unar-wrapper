<?php


namespace Tests\Units\Unar;


use Tests\TestCase;
use SystemUtil\Archiver\UnarCommand;


class UnarExtractTest  extends  TestCase{
  
  public function test_get_file_in_archive(){
    $sample_zip = __DIR__.'/unar-test-data/001-sample-img.zip';
    $data = UnarCommand::getFileContentByName($sample_zip,'*Dr*.jpg');
    $hash = md5($data);
    $this->assertEquals('e17f6bd9e897e25a2441f0dbd7df3f32',$hash);
    //
    $data = UnarCommand::getFileContentsAt($sample_zip,0);
    $hash = md5($data);
    $this->assertEquals('e17f6bd9e897e25a2441f0dbd7df3f32',$hash);
  }
  
  public function test_get_file_in_tar_archive_use_tmp(){
  
    $sample_zip = __DIR__.'/unar-test-data/003-sample.tar.gz';
    $data = UnarCommand::getFileContentByName($sample_zip,'sample01/sample02/002.txt');
    
    $this->assertStringContainsString('002', $data);
  }
  public function test_get_file_in_tar_archive_with_index(){
    
    $sample_zip = __DIR__.'/unar-test-data/003-sample.tar.gz';
    $data = UnarCommand::getFileContentsAt($sample_zip,3);
    $this->assertStringContainsString('002', $data);
  }
  
  
  
}