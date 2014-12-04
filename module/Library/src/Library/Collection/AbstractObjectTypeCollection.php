<?php

namespace Library\Collection;

abstract class AbstractObjectTypeCollection extends AbstractTypeCollection
{
    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function checkType($value)
    {
        if ($this->interfaceOrObjectName && !is_a($value, $this->interfaceOrObjectName)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal class name, expected: %s, got %s', $this->interfaceOrObjectName, get_class($value))
            );
        }
    }
}