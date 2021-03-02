<?php


namespace Tests\SampleCode;
use Tests\TestCase;
use SystemUtil\Process;


class TestsExecuteSamplesTest  extends TestCase {
  
  public function testCheckSyntaxSamples() {
    
    $samples_file = glob(__DIR__.'/../../samples/src/*.php');
    foreach ($samples_file as $f_name) {
      
      $proc = new Process([trim(`which php`), '-l', $f_name]);
      $proc->run();
      if( ! $proc->getExitCode() == 0 ) {
        var_dump([$proc->getExitCode(), $f_name]);
      }
      $this->assertEquals(0, $proc->getExitCode());
    }
  }
  public function testCheckExecuteSamples() {
    
    $samples_file = glob(__DIR__.'/../../samples/src/*.php');
    foreach ($samples_file as $f_name) {
      
      
      $start = time();
      $proc = new Process([trim(`which php`), $f_name]);
      $proc->run();
      if (  (time() - $start) > 10){
        throw new \Exception(['long time exectuion.', $f_name]);
      }
      if( ! $proc->getExitCode() == 0
        || preg_match('/Stack trace/', $proc->getErrorOutput() )) {
        throw new \Exception(join("\n",[$proc->getExitCode(), $f_name, $proc->getErrorOutput()]));
      }
      $this->assertEquals(0, $proc->getExitCode());
    }
  }
}