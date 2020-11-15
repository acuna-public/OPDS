<?php
  
  require __DIR__.'/../Mash/Mash.php';
  
  require 'Author.php';
  require 'Book.php';
  require 'Provider.php';
  require 'author/OPDS1.php';
  require 'author/OPDS2.php';
  require 'book/OPDS1.php';
  require 'book/OPDS2.php';
  require 'providers/OPDS1.php';
  require 'providers/OPDS2.php';
  
  abstract class OPDS extends Mash {
    
    protected $param = [], $get = [], $provider;
    public $params = ['v', 'lang', 'cat'];
    
    abstract protected function getLang (): array;
    
    protected function getConfig (array $data): array {
      return $data;
    }
    
    protected function onShow (): string {
      
      $this->param = set_items ($this->params, $_GET);
      
      foreach ($this->getConfig (['v' => 1, 'charset' => 'utf-8']) as $key => $value)
        $this->config[$key] = $value;
      
      foreach ($this->params as $param)
      if (!$this->param[$param] and is_isset ($param, $this->config))
        $this->param[$param] = $this->config[$param];
      
      $langs = $this->getLang ();
      
      $keys = array_keys ($langs);
      
      if (!$this->param['cat']) $this->param['cat'] = 'home';
      
      $this->get = set_items (['v'], $_GET);
      
      try {
        
        $this->provider = $this->getProvider ();
        $this->setData ();
        
        if (!$this->param['lang']) $this->param['lang'] = 'en';
        
        if (!in_array ($this->param['lang'], $keys))
          $lang = 'en';
        else
          $lang = $this->param['lang'];
        
        $lang = $langs[$lang];
        
        if (!$this->provider->getTitle ())
          $this->provider->setTitle ($lang[0]);
        
        $this->provider->processCats ();
        
      } catch (\CurlException $e) {
        $this->provider->setTitle ($langs['en'][0]);
      }
      
      @header ('Content-type:'.$this->provider->getType ().'; Charset:'.$this->config['charset']);
      
      return $this->provider->toString ();
      
    }
    
    protected abstract function setData ();
    
    protected function getProvider (): \OPDS\Provider {
      
      if ($this->param['v'] == 2)
        return new \OPDS\Provider\OPDS2 ();
      else
        return new \OPDS\Provider\OPDS1 ();
      
    }
    
    protected function getPublication (): \OPDS\Book {
      
      if ($this->param['v'] == 2)
        return new \OPDS\Book\OPDS2 ($this->provider);
      else
        return new \OPDS\Book\OPDS1 ($this->provider);
      
    }
    
    protected function getAuthor (): \OPDS\Author {
      
      if ($this->param['v'] == 2)
        return new \OPDS\Author\OPDS2 ($this->provider);
      else
        return new \OPDS\Author\OPDS1 ($this->provider);
      
    }
    
  }