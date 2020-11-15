<?php
  
  namespace OPDS\Book;
  
  class OPDS1 extends \OPDS\Book {
    
    public $dom, $entry;
    protected $title;
    
    function __construct (\OPDS\Provider $provider) {
      
      parent::__construct ($provider);
      
      $this->dom = $this->provider->dom;
      $this->entry = $this->dom->createElement ('entry');
      
    }
    
    protected function setEntry ($key, $value) {
      $this->entry->appendChild ($this->dom->createElement ($key, $value));
    }
    
    function setTitle ($title) {
      
      if ($this->title)
        $this->entry->removeChild ($this->title);
      
      $this->title = $this->provider->createTitle ($title);
      $this->entry->appendChild ($this->title);
      
    }
    
    function setShortDescr ($text) {
      
      $elem = $this->dom->createElement ('content', $text);
      
      $elem->setAttribute ('type', 'text');
      
      $this->entry->appendChild ($elem);
      
    }
    
    function setDescr ($text) {
      
      $elem = $this->dom->createElement ('content', htmlentities ($text, ENT_XML1));
      
      $elem->setAttribute ('type', 'text/html');
      
      $this->entry->appendChild ($elem);
      
    }
    
    function setAuthor ($author) {
      
      if ($author instanceof \OPDS\Author)
        $this->entry->appendChild ($author->getData ());
      else
        $this->setEntry ('author', $author);
      
    }
    
    protected function setEntryNS ($key, $value) {
      $this->entry->appendChild ($this->dom->createElement ('dc:'.$key, $value));
    }
    
    function setLanguage ($language) {
      $this->setEntryNS ('language', $language);
    }
    
    function setPublisher ($publisher) {
      $this->setEntryNS ('publisher', $publisher);
    }
    
    function setItems () {
      
      foreach (['identifier', 'updated'] as $isset)
      if (isset ($this->data[$isset]))
        $this->setEntryNS ($isset, $this->data[$isset]);
      
    }
    
    function setLinks () {
      
      foreach ($this->data['links'] as $link) {
        
        $elem = $this->dom->createElement ('link');
        
        $elem->setAttribute ('href', $link['href']);
        
        if (isset ($link['type'])) {
          
          $elem->setAttribute ('rel', 'http://opds-spec.org/acquisition/open-access');
          $elem->setAttribute ('type', $link['type']);
          
        } else $elem->setAttribute ('type', 'application/atom+xml;profile=opds-catalog');
        
        $this->entry->appendChild ($elem);
        
      }
      
    }
    
    function setImages () {
      
      foreach ($this->data['images'] as $link) {
        
        $elem = $this->dom->createElement ('link');
        
        $elem->setAttribute ('href', $link['href']);
        $elem->setAttribute ('rel', 'http://opds-spec.org/image/thumbnail');
        
        if (!isset ($link['type']))
          $link['type'] = get_filetype ($link['href']);
        
        if ($link['type'] == 'jpg') $link['type'] = 'jpeg';
        
        $elem->setAttribute ('type', 'image/'.$link['type']);
        
        foreach (['width', 'height'] as $isset)
        if (isset ($link[$isset]))
          $elem->setAttribute ($isset, $link[$isset]);
        
        $this->entry->appendChild ($elem);
        
      }
      
    }
    
  }