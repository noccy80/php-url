<?php

namespace NoccyLabs\Url;

class UrlTest extends \PhpUnit\Framework\TestCase
{
    public function testCreate()
    {
        $this->assertEquals("https://google.com", Url::canonize("google.com", "https"));
        $this->assertEquals("http://google.com", Url::canonize("google.com"));
        $this->assertEquals("http://google.com", Url::create("google.com"));
    }
    
    public function testModify()
    {
        $url = new Url();
        $this->assertEquals("", $url->getURL());
        
        $url->scheme = "http";
        $this->assertEquals("http://", $url->getURL());

        $url->host = "domain";
        $this->assertEquals("http://domain", $url->getURL());

        $url->path = "/file";
        $this->assertEquals("http://domain/file", $url->getURL());

        $url->user = "user";
        $this->assertEquals("http://user@domain/file", $url->getURL());
        $url->pass = "pass";
        $this->assertEquals("http://user:pass@domain/file", $url->getURL());

        $url->query = "query";
        $this->assertEquals("http://user:pass@domain/file?query", $url->getURL());

        $url->fragment = "fragment";
        $this->assertEquals("http://user:pass@domain/file?query#fragment", $url->getURL());
        
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
        $this->assertEquals(
            "https://bar.com/index.php",
            Url::create($base)->apply("https://bar.com/index.php")
        );
        $this->assertEquals(
            "http://bar.com/index.php",
            Url::create($base)->apply("//bar.com/index.php")
        );
    }

    public function testApplyWithQuery()
    {
        $base = "http://domain.tld/some/url?test=1";

        $applied = Url::create($base)->apply("/other", true);
        $this->assertEquals(
            "/other",
            $applied->path
        );
        $this->assertEquals(
            "test=1",
            $applied->query
        );

        $applied = Url::create($base)->apply("/other", false);
        $this->assertEquals(
            "/other",
            $applied->path
        );
        $this->assertEquals(
            null,
            $applied->query
        );
    }
}        
