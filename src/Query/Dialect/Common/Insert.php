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

use Phossa2\Query\Traits\Clause\SetTrait;
use Phossa2\Query\Traits\Clause\TableTrait;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Interfaces\Statement\InsertStatementInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * Insert
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     InsertStatementInterface
 * @see     SelectStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Insert extends StatementAbstract implements InsertStatementInterface
{
    use ClauseTrait, TableTrait, SetTrait;

    /**
     * {@inheritDoc}
     */
    public function into(/*# string */ $table)
    {
        return $this->table($table);
    }

    /**
     * INSERT ... SELECT
     *
     * {@inheritDoc}
     */
    public function select()/*# : SelectStatementInterface */
    {
        return $this->getBuilder()->select()
            ->setPrevious($this)    // previous stmt is INSERT
            ->col(func_get_args())  // cols from select()
            ->table('');            // clear table list
    }

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'TABLE' => 'INTO',
            'SET' => '',
            'VALUES' => 'VALUES',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return 'INSERT';
    }
}
