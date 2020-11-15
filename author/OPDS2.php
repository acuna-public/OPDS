<?php
  
  namespace OPDS\Author;
  
  class OPDS2 extends \OPDS\Author {
    
    function getData () {
      
      if ($this->data['links']) {
        
        foreach ($this->data['links'] as $i => $link)
        $this->data['links'][$i] = ['href' => $link['href']];
        
      }
      
      return $this->data;
      
    }
    
    function setName ($name) {
      $this->data['name'] = $name;
    }
    
  }