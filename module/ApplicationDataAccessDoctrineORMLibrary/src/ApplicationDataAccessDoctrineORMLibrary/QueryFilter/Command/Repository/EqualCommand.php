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

namespace ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository;

use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandInterface;
use BusinessLogicLibrary\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class EqualCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_CONDITION_EQUAL;

    /**
     * @inheritdoc
     */
    public function execute($queryBuilder, Criteria $criteria)
    {
        if ($criteria->getType() !== self::$commandName) {
            return false;
        }

        /** @var QueryBuilder $queryBuilder */
        $aliases = $queryBuilder->getRootAliases();

        $columnName = $criteria->getKey();
        $preparedColumnName = reset($aliases) . '.' . $columnName;

        $param = ':' . $columnName . 'FilterByEqual';

        $queryBuilder->andWhere($queryBuilder->expr()->eq($preparedColumnName, $param))
            ->setParameter($param, $criteria->getValue());

        return true;
    }
}