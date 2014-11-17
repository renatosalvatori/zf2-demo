<?php

namespace Application\Library\QueryFilter\Command\Special;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Criteria;
use Application\Library\QueryFilter\QueryFilter;

class FieldsCommand implements CommandInterface
{
    public static $commandName = '$fields';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $value = explode(',', $value);
        $value = array_map('trim', $value);

        $queryFilter->addCriteria(new Criteria(Criteria::TYPE_SPECIAL_FIELDS, null, $value));

        return true;
    }
}