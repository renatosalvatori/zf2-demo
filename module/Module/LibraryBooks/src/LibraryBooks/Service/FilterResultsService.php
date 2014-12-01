<?php

namespace Module\LibraryBooks\Service;

use Library\QueryFilter\QueryFilter;
use Library\QueryFilter\Command\Repository\CommandCollection;
use Doctrine\ORM\Query;
use BusinessLogic\Books\Entity\BookEntity;
use BusinessLogic\Books\Repository\BooksRepositoryInterface;

class FilterResultsService
{

    /**
     * @var BooksRepositoryInterface
     */
    private $bookRepository;

    /**
     * @var \Library\QueryFilter\Command\Repository\CommandCollection
     */
    private $commandCollection;

    public function __construct(BooksRepositoryInterface $bookRepository, CommandCollection $commandCollection)
    {
        $this->bookRepository = $bookRepository;
        $this->commandCollection = $commandCollection;
    }

    /**
     * @param QueryFilter $queryFilter
     * @param int         $hydrationMode
     *
     * @return BookEntity[]|null
     */
    public function getFilteredResults(QueryFilter $queryFilter, $hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->bookRepository->findByQueryFilter($queryFilter, $this->commandCollection, $hydrationMode);
    }
}