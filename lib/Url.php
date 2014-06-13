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
    
    public static function canonize($url)
    {
        $o = new Url($url);
        return $o->getUrl();
    }
    
    public static function create($url)
    {
        return new Url($url);
    }
    
    public function __construct($url = null)
    {
        
        if ($url !== null) {
            $this->setUrl($url);
        }
        
    }
    
    public function setUrl($url)
    {

        if (null !== strpos($url,":")) {
            list($proto,$urlstr) = explode(":",$url,2);
            // Count the number of slashes at the start
            $sc = (strlen($urlstr) - strlen(ltrim($urlstr,"/")));
            // If no slashes, we simply add two.
            if ($sc == 0) { $sc = 2; }
            // If one slash, parse as an absolute path for
            // compatibility with PHP.
            if ($sc == 1) {
                $this->setProps([
                    "proto" => $proto,
                    "path" => $path,
                    "is_local" => true
                ]);
            } else {
                // URL
                $url = $proto . "://" . ltrim($urlstr,"/");
                $urlp = parse_url($url);
                $this->setProps($urlp);
            }


        }
        
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
        if (true == $this->props["is_local"]) {
            return $this->props["scheme"] . ":" . $this->props["path"];
        } else {
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
        
    }
    
    public function __toString()
    {
        return $this->getUrl();
    }
    
}
