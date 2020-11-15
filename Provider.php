<?php
  
  namespace OPDS;
  
  abstract class Provider {
    
    public $proxies = [];
    
    protected $cats = [], $pubs = [], $publication = [];
    
    abstract function getType (): string;
    abstract function toString (): string;
    
    abstract function numberOfItems ($num);
    abstract function itemsPerPage ($num);
    abstract function currentPage ($num);
    abstract function processCats ();
    abstract function setTitle ($title);
    abstract function getTitle ();
    
    final function addItem (array $item) {
      $this->cats[] = $item;
    }
    
    final function addPublication (\OPDS\Book $item) {
      $this->pubs[] = $item;
    }
    
    final function addFullPublication (\OPDS\Book $item) {
      $this->publication = $item;
    }
    
  }