<?php
  
  namespace OPDS\Provider;
  
  class OPDS2 extends \OPDS\Provider {
    
    public $content = ['metadata' => ['title' => '']];
    
    function processCats () {
      
      if ($this->cats) {
        
        $this->content['navigation'] = [];
        
        foreach ($this->cats as $cat) {
          
          $item = [
            
            'title' => $cat[1],
            'href' => $cat[0],
            'type' => 'application/opds+json',
            'rel' => 'self',
            
          ];
          
          if (is_isset (2, $cat))
            $item['description'] = $cat[2];
          
          if (is_isset (3, $cat))
            $item['images'] = $cat[3];
          
          $this->content['navigation'][] = $item;
          
        }
        
      }
      
      if ($this->pubs) {
        
        $this->content['publications'] = [];
        
        foreach ($this->pubs as $pub) {
          
          $pub->setData ();
          $this->content['publications'][] = $pub->data;
          
        }
        
      }
      
      if ($pub = $this->publication) {
        
        $pub->setData ();
        $this->content = $this->publication->data;
        
      }
      
    }
    
    function setTitle ($title) {
      $this->content['metadata']['title'] = trim ($title);
    }
    
    function getTitle () {
      return $this->content['metadata']['title'];
    }
    
    function numberOfItems ($num) {
      $this->content['metadata']['numberOfItems'] = $num;
    }
    
    function itemsPerPage ($num) {
      $this->content['metadata']['itemsPerPage'] = $num;
    }
    
    function currentPage ($num) {
      $this->content['metadata']['currentPage'] = $num;
    }
    
    function toString (): string {
      return array2json ($this->content);
    }
    
    function getType (): string {
      return 'text/json';
    }
    
  }