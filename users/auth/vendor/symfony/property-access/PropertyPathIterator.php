<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\PropertyAccess;

/**
 * Traverses a property path and provides additional methods to find out
 * information about the current element.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @extends \ArrayIterator<int, string>
 */
class PropertyPathIterator extends \ArrayIterator implements PropertyPathIteratorInterface
{
    public function __construct(
        protected PropertyPathInterface $path,
    ) {
        parent::__construct($path->getElements());
    }

    public function isIndex(): bool
    {
        return $this->path->isIndex($this->key());
    }

    public function isProperty(): bool
    {
        return $this->path->isProperty($this->key());
    }
}
