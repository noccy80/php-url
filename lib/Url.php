<?php

/*
 * Copyright (C) 2014, NoccyLabs
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

namespace NoccyLabs\Url;

/**
 * Encapsulates an URL and allows its parts to be modified, full or partial URLs
 * to be applied, and more.
 *
 * @author Christopher Vagnetoft <cvagnetoft@gmail.com>
 * @license GPL-3.0
 */
class Url {
    
    /** @var array The properties of the URL */
    private $props = array(
        "scheme" => null,
        "host" => null,
        "port" => null,
        "user" => null,
        "pass" => null,
        "path" => null,
        "query" => null,
        "fragment" => null,
        "is_local" => null
    );
    
    /**
     * Helper function to canonize a URL with a default scheme.
     *
     * @param string The URL to parse
     * @param string The default scheme (http)
     * @return string The canonized URL
     */
    public static function canonize($url, $default_scheme="http")
    {
        $o = new Url($url);
        if (!$o->scheme) {
            $o->scheme = $default_scheme;
        }
        return $o->getUrl();
    }
    
    /**
     * Helper function to create a URL object with a default scheme.
     *
     * @param string The URL to parse
     * @param string The default scheme (http)
     * @return NoccyLabs\Url\Url The parsed Url object
     */
    public static function create($url, $default_scheme="http")
    {
        $o = new Url($url);
        if (!$o->scheme) {
            $o->scheme = $default_scheme;
        }
        return $o;
    }

    /**
     * Constructor
     *
     * @param string The URL to parse
     */    
    public function __construct($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }
    }
    
    /**
     * Set the URL
     *
     * @param string The URL to set
     */
    public function setUrl($url)
    {

        $urlp = parse_url($url);
        $this->setProps($urlp);
        
    }
    
    /**
     * Apply a full or partial URL to the current URL and return a new object
     * containing the applied URL.
     *
     * @param string The URL segment to apply
     * @param bool If true, the query string will be included
     * @return NoccyLabs\Url\Url The applied URL object
     */
    public function apply($url, bool $withQuery=false)
    {
        $urlr = clone $this;
        $urln = new Url($url);
        // apply parts
        if ($urln->scheme) {
            return $urln;
        }
        if ($urln->host) {
            $urln->scheme = $urlr->scheme;
            return $urln;
        }
        // modify new and return
        if ($urln->query) {
            $urlr->query = $urln->query;
        } elseif ($urlr->query && !$withQuery) {
            $urlr->query = null;
        }
        if ($urln->fragment) {
            $urlr->fragment = $urln->fragment;
        }
        if ($urln->path) {
            $path = $urln->path;
            if ($path[0] == "/") {
                $urlr->path = $urln->path;
            } else {
                $urlr->path = dirname($urlr->path)."/".$urln->path;
            }
        }
        return $urlr;
    }
    
    /**
     * Assign properties from array
     *
     * @internal
     * @param array Properties to assign
     */
    private function setProps(array $props)
    {
        foreach ($this->props as $prop=>$value) {
            if (array_key_exists($prop,$props))
                $this->props[$prop] = $props[$prop];
            else
                $this->props[$prop] = null;
        }
        
    }

    /**
     * {@inheritDoc}
     */
    public function __get($prop)
    {
        return (array_key_exists($prop,$this->props))?
            $this->props[$prop]:null;
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function __set($prop,$value)
    {
        if (array_key_exists($prop,$this->props))
            $this->props[$prop] = (string)$value;
        else
            throw new \Exception("Invalid property access to Url: {$prop}");
    
    }
    
    /**
     * {@inheritDoc}
     */
    public function __isset($prop)
    {
        return array_key_exists($prop,$this->props);     
    }
    
    /**
     * Return the assembled canonical URL
     * 
     * @see __toString()
     * @return string The canonical URL
     */
    public function getUrl()
    {
        if (!$this->props["scheme"]) { return ""; }
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
    
    /**
     * Return the URL as a string
     *
     * @return string The URL as a string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
    
}
