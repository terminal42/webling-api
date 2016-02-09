<?php

namespace Terminal42\WeblingApi\Property;

/**
 * This class is a replacement for \SplEnum
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
     * Constructor.
     *
     * @param string|null $initial_value
     *
     * @throws \UnexpectedValueException
     */
    public function __construct($initial_value = null)
    {
        if (null === $initial_value) {
            $constants = $this->getConstList(true);

            $this->value = array_key_exists('__default', $constants) ? $constants['__default'] : null;

        } else {
            $constants = $this->getConstList();

            if (!in_array($initial_value, $constants, true)) {
                throw new \UnexpectedValueException(
                    sprintf('%s is not a valid enum value [%s]', $initial_value, implode(',', $constants))
                );
            }

            $this->value = $initial_value;
        }
    }

    /**
     * @param bool $include_default
     *
     * @return array
     */
    public function getConstList($include_default = false)
    {
        static $constants;

        if (null === $constants) {
            $class     = new \ReflectionClass($this);
            $constants = $class->getConstants();
        }

        if (!$include_default && array_key_exists('__default', $constants)) {
            return array_diff_key($constants, ['__default' => '']);
        }

        return $constants;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
