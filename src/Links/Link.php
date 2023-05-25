<?php

namespace Core\Links;

use Core\Interfaces\ULinkInterface;

/**
 * Represents a link with additional functionality for manipulating URIs and
 * rendering HTML anchor tags.
 */
class Link implements ULinkInterface
{

    /**
     * The URI string of the link.
     *
     * @var string
     */
    private string $href;

    /**
     * An array of link relation types.
     *
     * @var array
     */
    private array $rel;

    /**
     * An associative array of additional attributes for the link.
     *
     * @var array
     */
    private array $attributes;

    /**
     * Creates a new Link instance.
     *
     * @param string $href The URI string of the link.
     * @param array $rel An array of link relation types.
     * @param array $attributes Assoc array of additional attributes for the link.
     */
    public function __construct(string $href, array $rel = [], array $attributes = [])
    {
        $this->href = $href;
        $this->rel = $rel;
        $this->attributes = $attributes;
    }

    // LinkInterface...

    /**
     * @inheritDoc
     */
    public function getScheme(): string
    {
        return parse_url($this->href, PHP_URL_SCHEME) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getAuthority(): string
    {
        $userInfo = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        $authority = $host;
        if ($userInfo !== '') {
            $authority = $userInfo . '@' . $authority;
        }
        if (isset($port)) {
            $authority .= ':' . $port;
        }

        return $authority;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo(): string
    {
        return parse_url($this->href, PHP_URL_USER) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getHost(): string
    {
        return parse_url($this->href, PHP_URL_HOST) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getPort(): ?int
    {
        $port = parse_url($this->href, PHP_URL_PORT);
        return $port !== null ? (int) $port : null;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return parse_url($this->href, PHP_URL_PATH) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getQuery(): string
    {
        return parse_url($this->href, PHP_URL_QUERY) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getFragment(): string
    {
        return parse_url($this->href, PHP_URL_FRAGMENT) ?: '';
    }

    /**
     * @inheritDoc
     */
    public function withScheme(string $scheme): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('scheme', $scheme);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo(string $user, ?string $password = null): self
    {
        $userInfo = $user;
        if ($password !== null) {
            $userInfo .= ':' . $password;
        }

        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('user', $userInfo);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withHost(string $host): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('host', $host);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPort(?int $port): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('port', (string) $port);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPath(string $path): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('path', $path);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withQuery(string $query): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('query', $query);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withFragment(string $fragment): self
    {
        $uri = clone $this;
        $uri->href = $uri->replaceUriComponent('fragment', $fragment);
        return $uri;
    }

    /**
     * Replaces a specific component of the URI with the given value.
     *
     * @param string $component The component to replace.
     * @param string $value The new value for the component.
     * @return string The modified URI with the replaced component.
     */
    private function replaceUriComponent(string $component, string $value): string
    {
        $parsed = parse_url($this->href);
        $parsed[$component] = $value;
        return $this->buildUriFromParts($parsed);
    }

    /**
     * Builds a URI string from its individual parts.
     *
     * @param array $parts An associative array containing the URI parts.
     * @return string The constructed URI string.
     */
    private function buildUriFromParts(array $parts): string
    {
        $scheme = $parts['scheme'] ?? '';
        $authority = $parts['user'] ?? '';
        if (isset($parts['pass'])) {
            $authority .= ':' . $parts['pass'];
        }
        $authority .= (empty($authority) ? '' : '@') . ($parts['host'] ?? '');
        if (isset($parts['port'])) {
            $authority .= ':' . $parts['port'];
        }
        $path = $parts['path'] ?? '';
        $query = $parts['query'] ?? '';
        $fragment = $parts['fragment'] ?? '';

        $uri = $scheme !== '' ? $scheme . ':' : '';
        $uri .= $authority !== '' ? '//' . $authority : '';
        $uri .= $path !== '' ? $path : '';
        $uri .= $query !== '' ? '?' . $query : '';
        $uri .= $fragment !== '' ? '#' . $fragment : '';

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $rel = implode(' ', $this->rel);
        $attributes = '';
        foreach ($this->attributes as $name => $value) {
            $attributes .= sprintf(' %s="%s"', $name, htmlspecialchars($value));
        }
        return sprintf('<a href="%s" rel="%s"%s>', htmlspecialchars($this->href), $rel, $attributes);
    }

    /**
     * @inheritDoc
     */
    public function getRels(): array
    {
        return $this->rel;
    }

    /**
     * @inheritDoc
     */
    public function hasRel(string $rel): bool
    {
        return in_array($rel, $this->rel);
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @inheritDoc
     */
    public function isTemplated(): bool
    {
        return preg_match('/\{.*\}/', $this->href) === 1;
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(string $name): string|null
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function withHref(string|\Stringable $href): static
    {
        $new = clone $this;
        $new->href = (string) $href;
        return $new;
    }

    /**
     * @inheritDoc
     */
    public function withRel(string ...$rel): static
    {
        $new = clone $this;
        $new->rel = $rel;
        return $new;
    }

    /**
     * @inheritDoc
     */
    public function withoutRel(string $rel): static
    {
        $clone = clone $this;
        $clone->rel = array_diff($clone->rel, (array) $rel);
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function withAttribute(string $attribute, string|\Stringable|int|float|bool|array $value): static
    {
        $new = clone $this;
        $new->attributes[$attribute] = $value;
        return $new;
    }

    /**
     * @inheritDoc
     */
    public function withoutAttribute(string $attribute): static
    {
        $new = clone $this;
        unset($new->attributes[$attribute]);
        return $new;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->href;
    }

}
