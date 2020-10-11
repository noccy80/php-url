<?php

namespace NoccyLabs\Url;

class QueryStringTest extends \PhpUnit\Framework\TestCase
{
    public function testCreateEmpty()
    {
        $qs = new QueryString();
        $this->assertEquals("", (string)$qs);
    }
    
    public function testCreateString()
    {
        $qs = new QueryString("foo=a&bar=b");
        $this->assertTrue( $qs->has("foo") );
        $this->assertEquals( "a", $qs->get("foo") );
        $this->assertTrue( $qs->has("bar") );
        $this->assertEquals( "b", $qs->get("bar") );
        $this->assertEquals("foo=a&bar=b", (string)$qs);
    }
    
    public function testBuild()
    {
        $qs = new QueryString();
        $qs->set("foo","a");
        $qs->set("bar","b");
        $this->assertTrue( $qs->has("foo") );
        $this->assertEquals( "a", $qs->get("foo") );
        $this->assertTrue( $qs->has("bar") );
        $this->assertEquals( "b", $qs->get("bar") );
        $this->assertEquals("foo=a&bar=b", (string)$qs);
    }
    
    public function testRemove()
    {
        $qs = new QueryString("foo=a&bar=b");
        $qs->remove("foo");
        $this->assertNotTrue( $qs->has("foo") );
        $this->assertEquals("bar=b", (string)$qs);
    }

}        
