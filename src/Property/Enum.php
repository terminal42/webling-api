<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Property;

/**
 * This class is a replacement for \SplEnum.
 *
 * @see http://de2.php.net/manual/en/class.splenum.php
 */
abstract class Enum implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @throws \UnexpectedValueException
     */
    public function __construct(string $initial_value = null)
    {
        if (null === $initial_value) {
            $constants = $this->getConstList(true);

            $this->value = \array_key_exists('__default', $constants) ? $constants['__default'] : null;
        } else {
            $constants = $this->getConstList();

            if (!\in_array($initial_value, $constants, true)) {
                throw new \UnexpectedValueException(sprintf('%s is not a valid enum value [%s]', $initial_value, implode(',', $constants)));
            }

            $this->value = $initial_value;
        }
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public static function getConstList(bool $include_default = false): array
    {
        $class = new \ReflectionClass(static::class);
        $constants = $class->getConstants();

        if (!$include_default && \array_key_exists('__default', $constants)) {
            return array_diff_key($constants, ['__default' => '']);
        }

        return $constants;
    }
}
