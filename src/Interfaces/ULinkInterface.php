<?php

namespace Core\Interfaces;

use Psr\Http\Message\UriInterface;
use Psr\Link\EvolvableLinkInterface;
use \Stringable;

/**
 * The ULinkInterface represents a link that combines the functionality of
 * EvolvableLinkInterface and UriInterface.
 */
interface ULinkInterface extends EvolvableLinkInterface, UriInterface
{

    /**
     * Get link clone with anchor
     * 
     * @param string $anchor Link anchor for render
     * @return self
     */
    public function withAnchor(string $anchor): self;

    /**
     * Get link anchor
     * 
     * @return string
     */
    public function getAnchor(): string;

    /**
     * Get children links, all or by attribute and value
     * 
     * @param string|null $attribute Attribute name
     * @param mixed $value Value of attribute if need
     * @return array Filtered or all attributes
     */
    public function getChildren(?string $attribute = null, mixed $value = null): array;

    /**
     * Get instance of this class with children items
     * 
     * @param ULinkInterface $children
     * @return self
     */
    public function withChildren(ULinkInterface ...$children): self;

    /**
     * Get clone of this object with many children items
     * 
     * @param array $children
     * @return self
     */
    public function withChildrens(array $children): self;

    /**
     * Get clone of this object with multiple attributes
     * 
     * @param array<string|Stringable|int|float|bool|array> $attributes
     * @return self
     */
    public function withAttributes(array $attributes): self;

    /**
     * Returns a new Link instance with the specified attribute added or updated.
     *
     * If the attribute already exists, the method appends the new value to the existing attribute value.
     * If the attribute does not exist, it is added with the provided value.
     *
     * @param string $attribute The name of the attribute.
     * @param string|Stringable|int|float|bool|array $value The value of the attribute.
     * @return self A new Link instance with the added or updated attribute.
     */
    public function withAddedAttribute(string $attribute, string|Stringable|int|float|bool|array $value): self;

    /**
     * Check if attribute exists
     * 
     * @param string $name
     * @return bool
     */
    public function hasAttribute(string $name): bool;

    /**
     * Renders the link as an HTML anchor element.
     *
     * @return string The HTML representation of the link.
     */
    public function render(): string;

    /**
     * Checks if the link has the specified relation type.
     *
     * @param string $rel The relation type to check.
     * @return bool True if the link has the specified relation type, false otherwise.
     */
    public function hasRel(string $rel): bool;

    /**
     * Retrieves the value of the specified attribute.
     *
     * @param string $name The name of the attribute.
     * @return string|null The value of the attribute, or null if the attribute does not exist.
     */
    public function getAttribute(string $name): string|null;
}
