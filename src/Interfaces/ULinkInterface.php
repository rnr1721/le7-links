<?php

namespace Core\Interfaces;

use Psr\Http\Message\UriInterface;
use Psr\Link\EvolvableLinkInterface;

/**
 * The ULinkInterface represents a link that combines the functionality of
 * EvolvableLinkInterface and UriInterface.
 */
interface ULinkInterface extends EvolvableLinkInterface, UriInterface
{

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
