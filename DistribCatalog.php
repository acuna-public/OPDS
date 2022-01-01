<?php
  
  require __DIR__.'/../Mash/Mash.php';
	
  abstract class DistribCatalog extends Mash {
    
    public $param = [], $get = ['v' => 1];
    public $params = ['lang', 'cat'];
    
    protected $adapter;
    
    abstract protected function getLang (): array;
    
    protected function getConf (array $data): array {
      return $data;
    }
    
    abstract function setData ();
    protected abstract function getAdapter ();
    
    protected function onShow (): string {
      
      $this->param = set_items ($this->params, $_GET);
      
      foreach ($this->getConf (['charset' => 'utf-8']) as $key => $value)
        $this->config[$key] = $value;
      
      foreach ($this->params as $param)
      if (!$this->param[$param] and is_isset ($param, $this->config))
        $this->param[$param] = $this->config[$param];
      
      $langs = $this->getLang ();
      
      $keys = array_keys ($langs);
      
      if (!$this->param['cat']) $this->param['cat'] = 'home';
      
      $this->get = set_items (['v'], $_GET);
      
      try {
        
        $this->adapter = $this->getAdapter ();
        $this->setData ();
        
        if (!$this->param['lang']) $this->param['lang'] = 'en';
        
        if (!in_array ($this->param['lang'], $keys))
          $lang = 'en';
        else
          $lang = $this->param['lang'];
        
        $lang = $langs[$lang];
        
        if (!$this->adapter->getTitle ())
          $this->adapter->setTitle ($lang[0]);
        
        $this->adapter->processCats ();
        
      } catch (\CurlException $e) {
        $this->adapter->setTitle ($langs['en'][0]);
      }
      
      @header ('Content-Type:'.$this->adapter->getType ().'; Charset:'.$this->config['charset']);
      
      return $this->adapter->toString ();
      
    }
    
  }