<?php

namespace Terminal42\WeblingApi\Property;

/**
 * This class is a replacement for \SplEnum
 *
 * @see http://de2.php.net/manual/en/class.splenum.php
 */
class Enum
{
    private $value;

    /**
     * Constructor.
     *
     * @param string|null $initial_value
     */
    public function __construct($initial_value = null)
    {
        if (null === $initial_value) {
            $constants = $this->getConstList(true);

            $this->value = isset($constants['__default']) ? $constants['__default'] : null;

        } else {
            $constants = $this->getConstList();

            if (!in_array($initial_value, $constants)) {
                throw new \InvalidArgumentException(
                    sprintf('%s is not a valid enum value [%s]', $initial_value, implode(',', $constants))
                );
            }
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

        if (!$include_default && isset($constants['__default'])) {
            return array_diff_key($constants, ['__default' => '']);
        }

        return $constants;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
