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
 * Helps parse and work with query strings.
 *
 * @author Christopher Vagnetoft <cvagnetoft@gmail.com>
 * @license GPL-3.0
 */
class QueryString
{
    /** @var array The parameters of the query string */
    protected $params = array();

    /**
     * Constructor
     *
     * @params array|string|null The initial query string as an array or string
     */    
    public function __construct($params=null)
    {
        if (is_string($params)) {
            parse_str($params, $this->params);
        } elseif (is_array($params)) {
            $this->params = $params;
        }
    }

    /**
     * Set a segment in the query string
     *
     * @param string The name to set
     * @param mixed The value to set
     */
    public function set($name, $param)
    {
        $this->params[$name] = $param;
    }
    
    /**
     * Check if a key exists in the query string
     *
     * @param string The key to look for
     * @return bool True if the key exists
     */
    public function has($name)
    {
        return array_key_exists($name, $this->params);
    }
    
    /**
     * Return a value from the query string based on its key.
     *
     * @param string The key to look for
     * @return mixed The value
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            return null;
        }
        return $this->params[$name];
    }
    
    /**
     * Remove a value from the query string based on its key
     *
     * @param string The key to remove
     */
    public function remove($name)
    {
        unset($this->params[$name]);
    }
    
    /**
     * Convert the query string to an actual string.
     *
     * @return string The formatted query string
     */
    public function __toString()
    {
        if (count($this->params) == 0) {
            return "";
        }
        return http_build_query($this->params);
    }
}

