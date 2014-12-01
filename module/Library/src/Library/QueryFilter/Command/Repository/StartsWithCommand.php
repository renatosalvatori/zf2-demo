<?php

namespace Library\QueryFilter\Command\Repository;

use Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class StartsWithCommand extends AbstractCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_CONDITION_STARTS_WITH;

    /**
     * @param QueryBuilder $qb
     * @param Criteria     $criteria
     * @param array        $entityFieldNames
     * @param string       $alias
     * @param int          $i
     *
     * @return bool
     */
    public function execute(QueryBuilder $qb, Criteria $criteria, array $entityFieldNames, $alias, $i)
    {
        if ($criteria->getType() !== self::$commandName) {
            return false;
        }

        $this->checkColumnNameInEntityFieldNames($criteria->getKey(), $entityFieldNames);
        $preparedColumnName = $this->prepareColumnName($criteria->getKey(), $alias);

        $param = ':startsWith' . $i;
        $qb->andWhere($qb->expr()->like($preparedColumnName, $param))
            ->setParameter($param, $criteria->getValue() . '%');

        return true;
    }
}