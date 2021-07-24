<?php
  
  namespace OPDS;
  
  abstract class Book {
    
    public $data = ['links' => [], 'images' => []];
    protected $adapter;
    
    function __construct (\OPDS\Adapter\OPDS1 $adapter) {
      $this->adapter = $adapter;
    }
    
    abstract function setTitle ($title);
    abstract function setAuthor ($author);
    abstract function setLanguage ($language);
    abstract function setPublisher ($publisher);
    abstract function setShortDescr ($text);
    abstract function setDescr ($text);
    abstract function setItems ();
    abstract function setLinks ();
    abstract function setImages ();
    
    function setData () {
      
      $this->setItems ();
      $this->setImages ();
      $this->setLinks ();
      
    }
    
    function setLink ($link) {
      $this->data['links'][] = $link;
    }
    
    function setImage ($image) {
      $this->data['images'][] = $image;
    }
    
  }