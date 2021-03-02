<?php


namespace SystemUtil\Archiver;


class UnArchiver implements \IteratorAggregate {
  
  protected $file_path;
  
  public function getArchiveFilePath () {
    if ( is_null( $this->file_path ) ) throw  new \RuntimeException( 'open() file first.' );
    return $this->file_path;
  }
  
  public function open ( string $archiveFile ) {
    if ( !file_exists( $archiveFile ) )
      throw new  \RuntimeException( "{$archiveFile} is not existing file." );
    if ( !is_readable( $archiveFile ) )
      throw new  \RuntimeException( "{$archiveFile} is not readable file." );
    if ( !LsarCommand::check( $archiveFile ) )
      throw new  \RuntimeException( "{$archiveFile} is broken file." );
    //
    $this->file_path = $archiveFile;
  }
  
  public function getFileContentByFileName ( string $name ) {
    return UnarCommand::getFileContentByName( $this->getArchiveFilePath(), $name );
  }
  
  public function getFileContentAt ( $index, $glob = null ) {
    $ret = $this->list( $glob, $index );
    // if files in subdirectory, i(=0) is always point to directory.
    // so, $index should be incremented.
    if ( preg_match( '|/$|', $ret[0], ) ) {
      $index = $index + 1;
    }
    return UnarCommand::getFileContentsAt( $this->getArchiveFilePath(), $index, $glob );
  }
  
  public function list ( $glob = null, $index = null ) {
    $args = [$this->getArchiveFilePath()];
    if ( !is_null( $index ) ) {
      $args = array_merge( $args, ['-i', $index] );
    }
    if ( !is_null( $glob ) ) {
      $args = array_merge( $args, is_array( $glob ) ? $glob : [$glob] );
    }
    $ret = LsarCommand::list( ...$args );
    $list = preg_split( '/\n/', $ret[1] );
    $list = array_filter( $list, 'trim' );
    $list = array_filter( $list );
    array_shift( $list );
    return $list;
  }
  
  public function filter ( $glob = null ) {
    return new UnArchiverIterator( $this, $glob );
  }
  
  public function count ( $glob = null ) {
    return count( $this->list( $glob ) );
  }
  
  public function getIterator ( $glob = null ) {
    return $this->filter( $glob );
  }
  
  
  public function getEntryByName( $name ) {
    $e = new UnArchiverEntry( $this, $name );
    return $e;
  }
  public function getEntryAt( $index, $glob = null ) {
    $ret = $this->list( $glob, $index );
    $e = new UnArchiverEntry( $this, $ret[0] );
    return $e;
  }
  public function getEntries($glob=null){
    $ret = $this->list( $glob );
    $_this = $this;
    return array_map(function($e)use($_this){ return new UnArchiverEntry($_this, $e); }, $ret);
  }
  
}