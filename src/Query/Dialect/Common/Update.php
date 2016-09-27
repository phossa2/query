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

use Phossa2\Query\Traits\Clause\TableTrait;
use Phossa2\Query\Traits\Clause\WhereTrait;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Traits\Clause\UpdateTrait;
use Phossa2\Query\Interfaces\Statement\UpdateStatementInterface;

/**
 * Update
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     UpdateStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Update extends StatementAbstract implements UpdateStatementInterface
{
    use ClauseTrait, UpdateTrait, TableTrait, WhereTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'TABLE' => '',
            'SET' => 'SET',
            'WHERE' => 'WHERE',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return 'UPDATE';
    }
}
