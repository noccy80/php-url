<?php

namespace NoccyLabs\Url;

class UrlTest extends \PhpUnit_Framework_TestCase
{
    public function setup()
    {}
    
    public function teardown()
    {}
    
    public function testCreate()
    {
        $this->markTestIncomplete();
    }
    
    public function testModify()
    {
        $this->markTestIncomplete();
    }
    
    public function testCanonize()
    {
        
        $this->assertEquals("http://google.com", Url::canonize("google.com"));
            
        $this->assertEquals("http://foo.com/bar?baz=true", Url::canonize("foo.com/bar?baz=true"));
        
    }
    
    public function testApply()
    {
        $base = "http://domain.tld/path/to/file.html";

        $this->assertEquals(
            "http://domain.tld/path/to/image.jpg",
            Url::create($base)->apply("image.jpg")
        );
        $this->assertEquals(
            "http://domain.tld/image.jpg",
            Url::create($base)->apply("/image.jpg")
        );
        $this->assertEquals(
            "http://other.dom/image.jpg",
            Url::create($base)->apply("http://other.dom/image.jpg")
        );
    }
}        
