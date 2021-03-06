<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BusinessLogicLibraryTest\QueryFilter\Command\Condition;

use BusinessLogicLibrary\QueryFilter\Command\Condition\EqualCommand;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class EqualCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EqualCommand
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $queryFilterMock;

    public function setUp()
    {
        $this->queryFilterMock = $this->getMockBuilder(QueryFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new EqualCommand();
    }

    /**
     * @dataProvider dataProviderForTestExecute
     *
     * @param string $key
     * @param string $value
     * @param bool   $expectedResult
     */
    public function testExecute($key, $value, $expectedResult)
    {
        if ($expectedResult) {
            $this->queryFilterMock->expects($this->once())
                ->method('addCriteria');
        }

        $result = $this->testedObject->execute($key, $value, $this->queryFilterMock);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestExecute()
    {
        return [
            ['author', '"Robert C. Martin"', true],
            ['title', 'Some title', false],
            ['title', '"Some" title', false],
            ['title', 'Some "title"', false],
            ['author', '"Robert C. Martin","Martin Fowler"', false]
        ];
    }
}