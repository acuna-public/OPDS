<?php
  
  namespace OPDS\Author;
  
  class OPDS1 extends \OPDS\Author {
    
    protected $dom, $entry;
    
    function __construct (\OPDS\Provider $provider) {
      
      parent::__construct ($provider);
      
      $this->dom = $this->provider->dom;
      $this->entry = $this->dom->createElement ('author');
      
    }
    
    protected function setEntry ($key, $value) {
      $this->entry->appendChild ($this->dom->createElement ($key, $value));
    }
    
    function getData () {
      
      if ($this->data['links'])
        $this->setEntry ('uri', $this->data['links'][0]['href']);
      
      return $this->entry;
      
    }
    
    function setName ($name) {
      $this->setEntry ('name', $name);
    }
    
  }