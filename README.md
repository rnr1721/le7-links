# le7-links
PSR LinkInterface implementation for le7 MVC framework or any PHP8 PSR project
This is not "clean" implementation, this is combination of
EnvolvedLinkInterface, UriInterface and own ULinkInterface.

## Requirements

- PHP 8.1
- Composer

## Installation

```shell
composer require rnr1721/le7-links
```

## Testing

```shell
composer test
```

## Usage

### Link

The Link class represents a LinkInterface, UriInterface and own ULinkInterface
with additional functionality for manipulating URIs and rendering HTML anchor
tags.

First, import the Link class:

```php
use Core\Links\Link;
```

Create an instance of the Link class by providing the URI, link relation
types, and additional attributes:

```php
$link = new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']);
```

#### Retrieving URI Components

You can retrieve different components of the URI using the following methods:

```php
$scheme = $link->getScheme();
$authority = $link->getAuthority();
$userInfo = $link->getUserInfo();
$host = $link->getHost();
$port = $link->getPort();
$path = $link->getPath();
$query = $link->getQuery();
$fragment = $link->getFragment();
```

#### Modifying URI Components

You can create a modified version of the link by using the following methods:

```php
$newLink = $link->withScheme('https');
$newLink = $link->withUserInfo('username', 'password');
$newLink = $link->withHost('example.com');
$newLink = $link->withPort(8080);
$newLink = $link->withPath('/new-path');
$newLink = $link->withQuery('param1=value1&param2=value2');
$newLink = $link->withFragment('section1');
```

#### Rendering HTML Anchor Tags

To render the link as an HTML anchor tag, use the render method:

```php
$html = $link->render();
```

The render method returns a string containing the HTML anchor tag.

#### Link Attributes

You can retrieve and modify the link's relation types and additional
attributes using the following methods:

```
$rels = $link->getRels();
$hasRel = $link->hasRel('rel1');
$attributes = $link->getAttributes();
$href = $link->getHref();
$isTemplated = $link->isTemplated();
$attributeValue = $link->getAttribute('attribute1');
```

You can create a modified version of the link with updated relation types and
attributes using the following methods:

```php
$newLink = $link->withHref('https://example.com/page2');
$newLink = $link->withRel('rel2', 'rel3');
$newLink = $link->withoutRel('rel1');
$newLink = $link->withAttribute('attribute2', 'value2');
$newLink = $link->withoutAttribute('attribute1');
```

#### String Conversion

You can obtain the string representation of the link using the magic
__toString method:

```php
$string = (string)$link;
```

### LinkProvider

The LinkProvider class is an implementation of the
EvolvableLinkProviderInterface from the PSR-Link library. It is used to store
and manage links.

First, import the LinkProvider class:

```php
use Core\Links\LinkProvider;
```

Create an instance of the LinkProvider class:

```php
$linkProvider = new LinkProvider();
```

#### Adding Links

To add a link to the provider, use the withLink method:

```php
use Core\Links\Link;

$link = new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']);
$linkProvider = $linkProvider->withLink($link);
```

You can chain multiple withLink calls to add multiple links:

```php
$link1 = new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']);
$link2 = new Link('https://example.com/page2', ['rel2'], ['attribute2' => 'value2']);

$linkProvider = $linkProvider->withLink($link1)
                           ->withLink($link2);
```

#### Retrieving Links

To retrieve all the links in the provider, use the getLinks method:

```php
$links = $linkProvider->getLinks();
```

The getLinks method returns an array of LinkInterface objects.

#### Removing Links

To remove a link from the provider, use the withoutLink method:

```php
$linkProvider = $linkProvider->withoutLink($link);
```

#### Filtering Links

To retrieve links based on their relationship, use the getLinksByRel method:

```php
$filteredLinks = $linkProvider->getLinksByRel('rel1');
```

The getLinksByRel method returns an array of LinkInterface objects that have
the specified relationship.

#### Adding Multiple Links

To add multiple links at once, use the withLinks method:

```php
$links = [
    new Link('https://example.com/page1', ['rel1'], ['attribute1' => 'value1']),
    new Link('https://example.com/page2', ['rel2'], ['attribute2' => 'value2']),
];

$linkProvider = $linkProvider->withLinks($links);
```

#### Removing Multiple Links

To remove multiple links at once, use the withoutLinks method:

```php
$linkProvider = $linkProvider->withoutLinks($links);
```

The withoutLinks method takes an array of LinkInterface objects and removes
them from the provider.
