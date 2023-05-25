<?php

use Core\Links\Link;
use Core\Links\LinkProvider;
use PHPUnit\Framework\TestCase;
use Psr\Link\LinkInterface;

class LinkProviderTest extends TestCase
{

    public function testGetLinks()
    {
        $link1 = new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']);
        $link2 = new Link('https://example.com/page2', ['rel2'], ['attribute2' => 'value2']);

        $lpObject = new LinkProvider();
        $linkProviderl1 = $lpObject->withLink($link1);
        $linkProvider = $linkProviderl1->withLink($link2);

        $links = $linkProvider->getLinks();

        $this->assertCount(2, $links);
        $this->assertInstanceOf(LinkInterface::class, $links[0]);
        $this->assertInstanceOf(LinkInterface::class, $links[1]);
    }

    public function testWithLink()
    {
        $link = new Link('https://example.com/page', ['rel'], ['attribute' => 'value']);

        $linkProvider = new LinkProvider();
        $newLinkProvider = $linkProvider->withLink($link);

        $this->assertNotSame($linkProvider, $newLinkProvider);
        $this->assertCount(1, $newLinkProvider->getLinks());
        $this->assertInstanceOf(LinkInterface::class, $newLinkProvider->getLinks()[0]);
        $this->assertEquals($link, $newLinkProvider->getLinks()[0]);
    }

    public function testWithoutLink()
    {
        $link1 = new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']);
        $link2 = new Link('https://example.com/page2', ['rel2'], ['attribute2' => 'value2']);

        $lpObject = new LinkProvider();
        $linkProviderl1 = $lpObject->withLink($link1);
        $linkProvider = $linkProviderl1->withLink($link2);

        $newLinkProvider = $linkProvider->withoutLink($link1);

        $this->assertNotSame($linkProvider, $newLinkProvider);
        $this->assertCount(1, $newLinkProvider->getLinks());
        $this->assertInstanceOf(LinkInterface::class, $newLinkProvider->getLinks()[1]);
        $this->assertEquals($link2, $newLinkProvider->getLinks()[1]);
    }

}
