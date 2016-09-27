<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa2\Query
 * @copyright Copyright (c) 2016 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa2\Query\Dialect\Common;

use Phossa2\Query\Traits\Clause\ColTrait;
use Phossa2\Query\Traits\Clause\TableTrait;
use Phossa2\Query\Traits\Clause\JoinTrait;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\WhereTrait;
use Phossa2\Query\Traits\Clause\LimitTrait;
use Phossa2\Query\Traits\Clause\UnionTrait;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Traits\Clause\HavingTrait;
use Phossa2\Query\Traits\Clause\GroupTrait;
use Phossa2\Query\Traits\Clause\OrderTrait;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * Select
 *
 * Implementation of SelectStatementInterface for Common dialect
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     SelectStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Select extends StatementAbstract implements SelectStatementInterface
{
    use ClauseTrait, ColTrait, TableTrait, WhereTrait, JoinTrait,
        GroupTrait, HavingTrait, OrderTrait, LimitTrait, UnionTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'DISTINCT' => '',
            'COL' => '',
            'TABLE' => 'FROM',
            'JOIN' => '',
            'WHERE' => 'WHERE',
            'GROUP' => 'GROUP BY',
            'HAVING' => 'HAVING',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
            'UNION' => '',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return 'SELECT';
    }
}
