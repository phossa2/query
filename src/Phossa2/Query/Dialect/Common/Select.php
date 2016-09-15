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
use Phossa2\Query\Traits\Clause\FromTrait;
use Phossa2\Query\Traits\Clause\JoinTrait;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\WhereTrait;
use Phossa2\Query\Traits\Clause\LimitTrait;
use Phossa2\Query\Traits\Clause\UnionTrait;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Traits\Clause\HavingTrait;
use Phossa2\Query\Traits\Clause\GroupByTrait;
use Phossa2\Query\Traits\Clause\OrderByTrait;
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
    use ClauseTrait, ColTrait, FromTrait, WhereTrait, JoinTrait,
        GroupByTrait, HavingTrait, OrderByTrait, LimitTrait, UnionTrait;

    /**
     * {@inheritDoc}
     */
    protected $configs = [
        'DISTINCT' => '',
        'COL' => '',
        'FROM' => 'FROM',
        'JOIN' => '',
        'WHERE' => 'WHERE',
        'GROUPBY' => 'GROUP BY',
        'HAVING' => 'HAVING',
        'ORDERBY' => 'ORDER BY',
        'LIMIT' => 'LIMIT',
        'UNION' => '',
    ];

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return 'SELECT';
    }
}
