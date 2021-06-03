<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Property;

/**
 * An enhanced \SplEnum that supports multiple values.
 */
abstract class Multienum extends Enum
{
    /**
     * @throws \UnexpectedValueException
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(array $initial_value = null)
    {
        if (null === $initial_value) {
            $constants = $this->getConstList(true);

            $this->value = \array_key_exists('__default', $constants) ? $constants['__default'] : null;
        } else {
            $constants = $this->getConstList();
            $diff = array_diff($initial_value, $constants);

            if (0 === \count($diff)) {
                throw new \UnexpectedValueException(sprintf('%s are not a valid enum values [%s]', implode(',', $diff), implode(',', $constants)));
            }

            $this->value = $initial_value;
        }
    }

    public function __toString(): string
    {
        return implode(', ', $this->value);
    }
}
