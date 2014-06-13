<?php

namespace NoccyLabs\Url;

class Url {
    
    private $props = [
        "scheme" => "file",
        "host" => null,
        "port" => null,
        "user" => null,
        "pass" => null,
        "path" => null,
        "query" => null,
        "fragment" => null,
        "is_local" => null
    ];
    
    public static function canonize($url, $default_scheme="http")
    {
        $o = new Url($url);
        if (!$o->scheme) { $o->scheme = $default_scheme; }
        return $o->getUrl();
    }
    
    public static function create($url)
    {
        return new Url($url);
    }
    
    public function __construct($url = null)
    {
        
        if ($url) {
            $this->setUrl($url);
        }
        
    }
    
    public function setUrl($url)
    {

        $urlp = parse_url($url);
        $this->setProps($urlp);
        
    }
    
    private function setProps(array $props)
    {
        foreach ($this->props as $prop=>$value) {
            if (array_key_exists($prop,$props))
                $this->props[$prop] = $props[$prop];
            else
                $this->props[$prop] = null;
        }
        
    }

    public function __get($prop)
    {
        return (array_key_exists($prop,$this->props))?
            $this->props[$prop]:null;
        
    }
    
    public function __set($prop,$value)
    {
        if (array_key_exists($prop,$this->props))
            $this->props[$prop] = $value;
        else
            throw new \Exception("Invalid property access to Url: {$prop}");
    
    }
    
    public function __isset($prop)
    {
        return array_key_exists($prop,$this->props);     
    }
    
    /**
     * @brief Return the assembled URI
     * 
     * @see __toString()
     *
     */
    public function getUrl()
    {
        return $this->props["scheme"] . "://" .
                (
                    (!empty($this->props["user"]))?(
                        $this->props["user"] .
                        ((!empty($this->props["pass"]))?":".$this->props["pass"]:"") .
                        "@"
                    ):""
                ) .
                $this->props["host"] .
                (
                    (!empty($this->props["port"]))?":".$this->props["port"]:""
                ) .
                ((!empty($this->props["path"]))?$this->props["path"]:"") .
                ((!empty($this->props["query"]))?"?".$this->props["query"]:"") .
                ((!empty($this->props["fragment"]))?"#".$this->props["fragment"]:"") 
            ;
        
    }
    
    public function __toString()
    {
        return $this->getUrl();
    }
    
}
