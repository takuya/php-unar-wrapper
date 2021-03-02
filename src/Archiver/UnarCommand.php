<?php


namespace SystemUtil\Archiver;


use SystemUtil\Process;

class UnarCommand extends GenericCommand {
  
  protected static $command_path;
  protected static $cmd_name = 'unar';
  
  
  public static function getFileContentByName( string $archive_file, string $file_name):string {
    
    if ( preg_match('/tgz$|tar\.gz/', $archive_file) ){
      return static::getFileContentsUsingTemp($archive_file, $file_name);
    }
    $ret = self::exec($archive_file, $file_name,'-o','-');
    
    if ($ret[0]!==0){
      throw new \RuntimeException('unar failed');
    }
    return $ret[1];
  }
  public static function getFileContentsAt( string $archive_file, int $index, $glob=null){
  
    if ( preg_match('/tgz$|tar\.gz/', $archive_file) ){
      return static::getFileContentsAtUsingTemp($archive_file, $index,$glob);
    }

    $ret = self::exec($archive_file, '-i',$index,'-o','-', $glob);
    if ($ret[0]!==0){
      throw new \RuntimeException('unar failed');
    }
    return $ret[1];
  }
  protected static function getFileContentsUsingTemp(string $archive_file, string $file_name):string {
    
    $tmp = tempnam(sys_get_temp_dir(), 'php-unar-'.base64_encode(random_bytes(9)));
    @unlink($tmp);
    $ret = self::exec($archive_file,'-o',$tmp, $file_name);
    $content = file_get_contents($tmp.'/'.$file_name);
    (new Process(['rm','-rf', $tmp]))->run();
  
    if ($ret[0]!==0){
      throw new \RuntimeException('unar failed');
    }
  
    return $content;
  }
  protected static function getFileContentsAtUsingTemp(string $archive_file, int $index, string $glob=null ):string {

    $args = [$archive_file,'-i', $index];
    if ( !is_null($glob)){
      $args = array_merge($args,(is_array($glob)?$glob:[$glob]));
    }
    $ret = LsarCommand::list(...$args);
    if ($ret[0]!==0){
      throw new \RuntimeException('unar failed');
    }
    $list = preg_split( '/\n/', $ret[1] );
    $list = array_filter( $list, 'trim' );
    $list = array_filter( $list );
    array_shift( $list );
    $name = $list[0];
    
    return static::getFileContentsUsingTemp($archive_file,$name);
  }
  
}