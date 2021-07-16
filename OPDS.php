<?php
  
  require 'DistribCatalog.php';
  require 'Author.php';
  require 'Book.php';
  require 'Adapter.php';
  require 'author/OPDS1.php';
  require 'author/OPDS2.php';
  require 'book/OPDS1.php';
  require 'book/OPDS2.php';
  require 'adapters/OPDS1.php';
  require 'adapters/OPDS2.php';
  
  abstract class OPDS extends DistribCatalog {
    
    protected function getAdapter () {
      
      if ($this->get['v'] == 2)
        return new OPDS\Adapter\OPDS2 ();
      else
        return new OPDS\Adapter\OPDS1 ();
      
    }
    
    protected function getPublication (): OPDS\Book {
      
      if ($this->get['v'] == 2)
        return new OPDS\Book\OPDS2 ($this->adapter);
      else
        return new OPDS\Book\OPDS1 ($this->adapter);
      
    }
    
    protected function getAuthor (): OPDS\Author {
      
      if ($this->get['v'] == 2)
        return new OPDS\Author\OPDS2 ($this->adapter);
      else
        return new OPDS\Author\OPDS1 ($this->adapter);
      
    }
    
  }