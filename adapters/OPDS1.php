<?php
  
  namespace OPDS\Adapter;
  
  class OPDS1 extends \OPDS\Adapter {
    
    public $dom, $root;
    protected $title;
    
    function __construct () {
      
      $this->dom = new \DOMDocument ('1.0', 'UTF-8');
      
      $this->root = $this->dom->createElement ('feed');
      
      $this->root->setAttribute (
        
        'xmlns',
        'http://www.w3.org/2005/Atom',
        
      );
      
      $this->root->setAttributeNS (
        
        'http://www.w3.org/2000/xmlns/', 
        'xmlns:dc',
        'http://purl.org/dc/terms/',
        
      );
      
      $this->root->setAttributeNS (
        
        'http://www.w3.org/2000/xmlns/', 
        'xmlns:opds',
        'http://opds-spec.org/2010/catalog',
        
      );
      
      $this->root = $this->dom->appendChild ($this->root);
      
      //$entry = $this->dom->createElement ('id', 'tag:root');
      
      //$this->root->appendChild ($entry);
      
    }
    
    function createTitle ($title) {
      return $this->dom->createElement ('title', htmlentities ($title, ENT_XML1));
    }
    
    function processCats () {
      
      if ($this->items) {
        
        foreach ($this->items as $cat) {
          
          $entry = $this->dom->createElement ('entry');
          
          $entry->appendChild ($this->createTitle ($cat[1]));
          
          $elem = $this->dom->createElement ('link');
          
          $elem->setAttribute ('href', $cat[0]);
          //$elem->setAttribute ('rel', 'subsection');
          $elem->setAttribute ('type', 'application/atom+xml;profile=opds-catalog');
          
          //if (is_isset (2, $cat))
          //  $item['description'] = $cat[2];
          
          //if (is_isset (3, $cat))
          //  $item['images'] = $cat[3];
          
          $entry->appendChild ($elem);
          
          $this->root->appendChild ($entry);
          
        }
        
      }
      
      foreach ($this->pubs as $pub) {
        
        $pub->setData ();
        $this->root->appendChild ($pub->entry);
        
      }
      
      if ($pub = $this->publication) {
        
        $pub->setData ();
        $this->root->appendChild ($pub->entry);
        
      }
      
    }
    
    function setTitle ($title) {
      
      if ($this->title)
        $this->root->removeChild ($this->title);
      
      $this->title = $this->createTitle (trim ($title));
      $this->root->appendChild ($this->title);
      
    }
    
    function getTitle () {
      return $this->title;
    }
    
    function numberOfItems ($num) {
      //$this->content['metadata']['numberOfItems'] = $num;
    }
    
    function itemsPerPage ($num) {
      //$this->content['metadata']['itemsPerPage'] = $num;
    }
    
    function currentPage ($num) {
      //$this->content['metadata']['currentPage'] = $num;
    }
    
    function toString (): string {
      return $this->dom->saveXML ();
    }
    
    function getType (): string {
      return 'text/xml';
    }
    
  }