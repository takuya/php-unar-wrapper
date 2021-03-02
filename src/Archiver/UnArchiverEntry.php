<?php


namespace SystemUtil\Archiver;


class UnArchiverEntry {

  /** @var UnArchiver */
  protected $unarchiver;
  protected $name;
  public function __construct ( UnArchiver $unarchiver, $name ) {
    $this->unarchiver=$unarchiver;
    $this->name=$name;
  }
  public function isDir(){
    return $this->isDirectory();
  }
  public function isDirectory(){
    return preg_match('|/$|', $this->name) >0;
  }
  public function content(){
    return $this->getContent();
  }
  public function getContent(){
    return $this->unarchiver->getFileContentByFileName($this->name);
  }
  public function getName(){
    return $this->name;
  }
  
}