<?php

use Core\Links\Link;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{

    public function testGetScheme()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('http', $link->getScheme());
    }

    public function testGetAuthority()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('example.com', $link->getAuthority());
    }

    public function testGetUserInfo()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('', $link->getUserInfo());
    }

    public function testGetHost()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('example.com', $link->getHost());
    }

    public function testGetPort()
    {
        $link = new Link('http://example.com:8080');
        $this->assertEquals(8080, $link->getPort());
    }

    public function testGetPath()
    {
        $link = new Link('http://example.com/path');
        $this->assertEquals('/path', $link->getPath());
    }

    public function testGetQuery()
    {
        $link = new Link('http://example.com?param=value');
        $this->assertEquals('param=value', $link->getQuery());
    }

    public function testGetFragment()
    {
        $link = new Link('http://example.com#section');
        $this->assertEquals('section', $link->getFragment());
    }

    public function testWithScheme()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withScheme('https');
        $this->assertEquals('https://example.com', $newLink->__toString());
    }

    public function testWithUserInfo()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withUserInfo('user', 'pass');
        $this->assertEquals('http://user:pass@example.com', $newLink->__toString());
    }

    public function testWithHost()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withHost('newhost.com');
        $this->assertEquals('http://newhost.com', $newLink->__toString());
    }

    public function testWithPort()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withPort(8080);
        $this->assertEquals('http://example.com:8080', $newLink->__toString());
    }

    public function testWithPath()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withPath('/newpath');
        $this->assertEquals('http://example.com/newpath', $newLink->__toString());
    }

    public function testWithQuery()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withQuery('param=newvalue');
        $this->assertEquals('http://example.com?param=newvalue', $newLink->__toString());
    }

    public function testWithFragment()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withFragment('newsection');
        $this->assertEquals('http://example.com#newsection', $newLink->__toString());
    }

    public function testToString()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('http://example.com', $link->__toString());
    }

    public function testRender()
    {
        $link = new Link('http://example.com');
        $rendered = $link->render();
        $this->assertStringContainsString('<a href="http://example.com"', $rendered);
    }

    public function testGetRels()
    {
        $link = new Link('http://example.com', ['rel1', 'rel2']);
        $this->assertEquals(['rel1', 'rel2'], $link->getRels());
    }

    public function testHasRel()
    {
        $link = new Link('http://example.com', ['rel1', 'rel2']);
        $this->assertTrue($link->hasRel('rel1'));
        $this->assertFalse($link->hasRel('rel3'));
    }

    public function testGetAttributes()
    {
        $link = new Link('http://example.com', [], ['attr1' => 'value1', 'attr2' => 'value2']);
        $this->assertEquals(['attr1' => 'value1', 'attr2' => 'value2'], $link->getAttributes());
    }

    public function testGetHref()
    {
        $link = new Link('http://example.com');
        $this->assertEquals('http://example.com', $link->getHref());
    }

    public function testIsTemplated()
    {
        $link = new Link('http://example.com');
        $this->assertFalse($link->isTemplated());
        $templatedLink = new Link('http://example.com/{param}');
        $this->assertTrue($templatedLink->isTemplated());
    }

    public function testGetAttribute()
    {
        $link = new Link('http://example.com', [], ['attr1' => 'value1', 'attr2' => 'value2']);
        $this->assertEquals('value1', $link->getAttribute('attr1'));
        $this->assertNull($link->getAttribute('attr3'));
    }

    public function testWithHref()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withHref('http://newexample.com');
        $this->assertEquals('http://newexample.com', $newLink->__toString());
    }

    public function testWithRel()
    {
        $link = new Link('http://example.com', ['rel1']);
        $newLink = $link->withRel('rel2', 'rel3');
        $this->assertEquals(['rel2', 'rel3'], $newLink->getRels());
    }

    public function testWithoutRel()
    {
        $link = new Link('http://example.com', ['rel1', 'rel2']);
        $newLink = $link->withoutRel('rel2');
        $this->assertEquals(['rel1'], $newLink->getRels());
    }

    public function testWithAttribute()
    {
        $link = new Link('http://example.com');
        $newLink = $link->withAttribute('attr1', 'value1');
        $this->assertEquals(['attr1' => 'value1'], $newLink->getAttributes());
    }

    public function testWithoutAttribute()
    {
        $link = new Link('http://example.com', [], ['attr1' => 'value1', 'attr2' => 'value2']);
        $newLink = $link->withoutAttribute('attr1');
        $this->assertEquals(['attr2' => 'value2'], $newLink->getAttributes());
    }
    
}
