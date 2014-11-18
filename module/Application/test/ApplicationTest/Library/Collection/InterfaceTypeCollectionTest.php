<?php

namespace ApplicationTest\Library\Collection;

use ApplicationTest\Library\Collection\Provider;

class InterfaceTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Provider\MyClassInterfaceCollection
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new Provider\MyClassInterfaceCollection(
            [
                new Provider\HisClass('a', 'b'),
                new Provider\HisClass(1, 2)
            ]
        );
    }

    public function testOffsetExist()
    {
        $result = $this->testedObject->offsetExists(1);

        $this->assertTrue($result);
    }

    public function testOffsetUnset()
    {
        $this->testedObject->offsetUnset(1);

        $result = $this->testedObject->offsetExists(1);

        $this->assertFalse($result);
    }

    public function testOffsetGet()
    {
        /** @var Provider\HisClass $result */
        $result = $this->testedObject->offsetGet(0);

        $this->assertInstanceOf(Provider\HisClass::class, $result);
        $this->assertSame(0, $result->getA());
        $this->assertSame(0, $result->getB());
    }

    public function testOffsetSet()
    {
        $this->testedObject->offsetSet(2, new Provider\HisClass(2, 5));

        /** @var Provider\MyClass $result */
        $result = $this->testedObject->offsetGet(2);

        $this->assertInstanceOf(Provider\HisClass::class, $result);
        $this->assertSame(2, $result->getA());
        $this->assertSame(5, $result->getB());
    }

    public function testOffsetSet_WithInvalidObject()
    {
        $this->setExpectedException(
            'UnexpectedValueException',
            'Illegal object, expected instance of: ApplicationTest\\Library\\Collection\\Provider\\MyClassInterface'
        );
        $this->testedObject->offsetSet(2, new Provider\NotMyClass(true, new \DateTime()));
    }
}