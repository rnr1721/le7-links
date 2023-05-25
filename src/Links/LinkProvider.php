<?php

namespace Core\Links;

use Psr\Link\EvolvableLinkProviderInterface;
use Psr\Link\LinkInterface;

/**
 * Class LinkProvider
 *
 * Implementation of EvolvableLinkProviderInterface that stores and manages links.
 */
class LinkProvider implements EvolvableLinkProviderInterface
{

    private array $links = [];

    /**
     * @inheritDoc
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @inheritDoc
     */
    public function withLink(LinkInterface $link): static
    {
        $clone = clone $this;
        $clone->links[] = $link;
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function withoutLink(LinkInterface $link): static
    {
        $clone = clone $this;
        $index = array_search($link, $clone->links, true);
        if ($index !== false) {
            unset($clone->links[$index]);
        }
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function getLinksByRel(string $rel): array
    {
        $filteredLinks = [];
        foreach ($this->links as $link) {
            if (in_array($rel, $link->getRels(), true)) {
                $filteredLinks[] = $link;
            }
        }
        return $filteredLinks;
    }

    /**
     * @inheritDoc
     */
    public function withLinks(array $links): self
    {
        $clone = clone $this;
        foreach ($links as $link) {
            if ($link instanceof LinkInterface) {
                $clone->links[] = $link;
            }
        }
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function withoutLinks(array $links): EvolvableLinkProviderInterface
    {
        $clone = clone $this;
        foreach ($links as $link) {
            $index = array_search($link, $clone->links, true);
            if ($index !== false) {
                unset($clone->links[$index]);
            }
        }
        return $clone;
    }

}
