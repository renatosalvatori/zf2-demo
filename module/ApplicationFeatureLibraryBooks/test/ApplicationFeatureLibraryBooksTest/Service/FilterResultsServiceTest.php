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

namespace ApplicationFeatureLibraryBooksTest\Service;

use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use BusinessLogicDomainBooks\Repository\BooksRepositoryInterface;
use BusinessLogicDomainBooksTest\Entity\Provider\BookEntityProvider;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class FilterResultsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilterResultsService
     */
    private $testedObj;

    /**
     * @var MockObject
     */
    private $bookRepositoryMock;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    public function setUp()
    {
        $this->bookEntityProvider = new BookEntityProvider();

        $this->bookRepositoryMock = $this->getMock(BooksRepositoryInterface::class);

        $this->testedObj = new FilterResultsService(
            $this->bookRepositoryMock,
            new CommandCollection([])
        );
    }

    public function testGetFilteredResult()
    {
        $bookEntity1 = $this->bookEntityProvider->getBookEntityWithRandomData();
        $bookEntity2 = $this->bookEntityProvider->getBookEntityWithRandomData();

        $books = [$bookEntity1, $bookEntity2];

        $this->bookRepositoryMock->expects($this->once())
            ->method('findByQueryFilter')
            ->will($this->returnValue($books));

        $result = $this->testedObj->getFilteredResults(new QueryFilter([], []));

        $this->assertSame($books, $result);
    }
}