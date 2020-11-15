<?php
  
  namespace OPDS;
  
  abstract class Author {
    
    public $data = ['links' => []];
    protected $provider;
    
    function __construct (\OPDS\Provider $provider) {
      $this->provider = $provider;
    }
    
    abstract function getData ();
    abstract function setName ($name);
    
    function setLink ($link) {
      $this->data['links'][] = $link;
    }
    
  }