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

use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\TableTrait;
use Phossa2\Query\Traits\Clause\WhereTrait;
use Phossa2\Query\Traits\Clause\OrderTrait;
use Phossa2\Query\Traits\Clause\LimitTrait;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Interfaces\Statement\DeleteStatementInterface;

/**
 * Delete
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Delete extends StatementAbstract implements DeleteStatementInterface
{
    use ClauseTrait, TableTrait, WhereTrait, OrderTrait, LimitTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'TABLE' => 'FROM',
            'WHERE' => 'WHERE',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return 'DELETE';
    }
}
