<?php

namespace Terminal42\WeblingApi\Property;

/**
 * An enhanced \SplEnum that supports multiple values.
 */
class Multienum extends Enum
{
    /**
     * @var array
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param array|null $initial_value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $initial_value = null)
    {
        if (null === $initial_value) {
            $constants = $this->getConstList(true);

            $this->value = isset($constants['__default']) ? $constants['__default'] : null;

        } else {
            $constants = $this->getConstList();
            $diff      = array_diff($initial_value, $constants);

            if (!empty($diff)) {
                throw new \InvalidArgumentException(
                    sprintf('%s is not a valid enum value [%s]', implode(',', $diff), implode(',', $constants))
                );
            }

            $this->value = $initial_value;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(', ', $this->value);
    }
}
