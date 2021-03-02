<?php


namespace SystemUtil\Archiver;


use SystemUtil\Process;

/**
 * @method static list_json( ...$arguments )
 * @method static test( ...$arguments )
 * @method static list( ...$arguments )
 * @method static list_long( ...$arguments )
 * @method static list_verylong( ...$arguments )
 */
class LsarCommand  extends  GenericCommand {
  protected static $command_path;
  protected static $cmd_name = 'lsar';
  protected static $options = [
    'test'=>'-t',
    'list'=>'',
    'list_long'=>'-l',
    'list_verylong'=>'-L',
    'list_json'=>'-j'
  ];
  
  public static function __callStatic ( $name, $arguments ) {
    return parent::__callStatic( $name, $arguments );
  }
  
  protected static function command_path() {
    $p = new Process(['which', self::$cmd_name]);
    $p->run();
    if ( $p->getExitCode() !== 0 ) {
      throw new \RuntimeException( '`lsar` command not found. try apt install unar.' );
    }
    self::$command_path = trim($p->getOutput());
  }
  public static function file_exists($archive_file, $filter){
    $ret = self::exec( '-j', $archive_file, $filter);
    $ret = json_decode($ret[1],true);
    return sizeof($ret['lsarContents'])>0;
  }
  public static function check($archive_file){
    // TODO: 一部が壊れたファイルをどうするか
    $ret = self::test($archive_file);
    return preg_match('/\d+\s+passed, 0 failed/mi',$ret[1]) > 0;
  }
  
  
}