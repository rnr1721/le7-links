<?php

namespace Core\Interfaces;

use Psr\Link\EvolvableLinkProviderInterface;

/**
 * Interface ULinkProviderInterface
 *
 * Extension of the EvolvableLinkProviderInterface that provides methods for
 * working with links.
 */
interface ULinkProviderInterface extends EvolvableLinkProviderInterface
{

    /**
     * Adds an array of links to the provider.
     *
     * @param array $links The array of links to be added to the provider.
     * @return self Returns the modified instance of the link provider.
     */
    public function withLinks(array $links): self;

    /**
     * Removes an array of links from the provider.
     *
     * @param array $links The array of links to be removed from the provider.
     * @return self Returns the modified instance of the link provider.
     */
    public function withoutLinks(array $links): self;
}
