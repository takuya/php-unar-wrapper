<?php


namespace SystemUtil\Archiver;


class UnArchiverIterator implements \Iterator, \Countable, \ArrayAccess {

  protected $unarchiver;
  protected $glob;
  protected $index;
  //
  protected $current;
  protected $list;
  
  public function __construct ( UnArchiver $unarchiver, $glob=null) {
    //
    $this->unarchiver = $unarchiver;
    $this->glob=$glob;
    //
    $this->list = $this->unarchiver->list($glob);
    $this->current=0;
  }
  
  public function current () {
    $name = $this->list[$this->current];
    return $this->unarchiver->getEntryByName($name);
  }
  
  public function next () {
    $this->current++;
  }
  
  public function key () {
    return $this->list[$this->current];
  }
  
  public function valid () {
    return $this->current < $this->count();
  }
  
  public function rewind () {
    $this->current > 0 && $this->current--;
  }
  
  public function count () {
    return sizeof($this->list);
  }
  
  public function offsetExists ( $offset ) {;
    return sizeof(array_filter($this->list, function($e)use($offset){return $e == $offset;}))>0;
  }
  
  public function offsetGet ( $offset ) {
    return $this->unarchiver->getFileContentByFileName($offset);
  }
  
  public function offsetSet ( $offset, $value ) {
    throw new \RuntimeException('Archiver is read only');
  }
  
  public function offsetUnset ( $offset ) {
    throw new \RuntimeException('Archiver is read only');
  }
}