<?php
  
  namespace OPDS\Book;
  
  class OPDS2 extends \OPDS\Book {
    
    public $data = ['metadata' => ['@type' => 'http://schema.org/Book'], 'images' => [], 'links' => []];
    
    function setTitle ($title) {
      $this->data['metadata']['title'] = trim ($title);
    }
    
    function setShortDescr ($text) {
      
    }
    
    function setDescr ($text) {
      
    }
    
    function setAuthor ($author) {
      
      if ($author instanceof \OPDS\Author)
        $this->data['metadata']['authors'][] = $author->getData ();
      else
        $this->data['metadata']['authors'][] = $author;
      
    }
    
    function setLanguage ($language) {
      $this->data['metadata']['language'] = $language;
    }
    
    function setPublisher ($publisher) {
      $this->data['metadata']['publisher'] = $publisher;
    }
    
    function setItems () {
      
      foreach (['identifier', 'modified'] as $isset)
      if (isset ($this->data['metadata'][$isset]))
        $this->data['metadata'][$isset] = $this->data['metadata'][$isset];
      
    }
    
    function setLinks () {
      
      foreach ($this->data['links'] as $i => $link) {
        
        if (isset ($link['rel']))
          $link['rel'] = 'http://opds-spec.org/acquisition'.($link['rel'] ? '/'.$link['rel'] : '');
        else
          $link['rel'] = 'application/webpub+json';
        
        $this->data['links'][$i] = $link;
        
      }
      
    }
    
    function setImages () {
      
      foreach ($this->data['images'] as $i => $link) {
        
        if (!isset ($link['type']))
          $link['type'] = get_filetype ($link['href']);
        
        if ($link['type'] == 'jpg') $link['type'] = 'jpeg';
        
        $image = ['href' => $link['href'], 'type' => 'image/'.$link['type']];
        
        foreach (['width', 'height'] as $isset)
        if (isset ($link[$isset]))
          $image[$isset] = $link[$isset];
        
        $this->data['images'][$i] = $image;
        
      }
      
    }
    
  }