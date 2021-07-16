<?php
  
  namespace OPDS;
  
  abstract class Adapter {
    
    public $proxies = [];
    
    protected $items = [], $pubs = [], $publication = [];
    
    function getType (): string {
      return 'text/json';
    }
    
    abstract function toString (): string;
    
    abstract function numberOfItems ($num);
    abstract function itemsPerPage ($num);
    abstract function currentPage ($num);
    abstract function setTitle ($title);
    abstract function getTitle ();
    abstract function processCats ();
    
    final function addItem (array $item) {
      $this->items[] = $item;
    }
    
    final function addPublication (Book $item) {
      $this->pubs[] = $item;
    }
    
    final function addFullPublication (Book $item) {
      $this->publication = $item;
    }
    
  }