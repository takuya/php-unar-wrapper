<?php


namespace SystemUtil\Archiver;


use SystemUtil\Process;

abstract  class GenericCommand {
  protected static $command_path;
  protected static $cmd_name ;
  protected static $options = [];
  protected static function command_path() {
    $p = new Process(['which', static::$cmd_name]);
    $p->run();
    if ( $p->getExitCode() !== 0 ) {
      throw new \RuntimeException( static::$cmd_name.' command not found. try "apt install unar".');
    }
    static::$command_path = trim($p->getOutput());
  }
  public static function exec(...$args): array {
    if ( empty( static::$command_path ) ) {
      static::command_path();
    }
    $args = array_merge( [], [static::$command_path], ...[$args] );
    $args = array_filter($args,'trim');
    $proc = new Process( $args );
    $proc->run();
    return [$proc->getExitCode(), $proc->getOutput(), $proc->getErrorOutput()];
  }
  
  public static function __callStatic ( $name, $arguments ) {
    if ( array_key_exists($name,static::$options)){
      $opt = static::$options[$name];
      $arguments = array_merge([],[$opt],$arguments);
      return static::exec(...$arguments);
    }
    return null;
  }
}