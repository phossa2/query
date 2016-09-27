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

namespace Phossa2\Query\Traits\Clause;

use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Interfaces\ExpressionInterface;
use Phossa2\Query\Interfaces\Clause\JoinInterface;

/**
 * JoinTrait
 *
 * Implementation of JoinInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     JoinInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait JoinTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function join($secondTable, $onClause = '')
    {
        return $this->realJoin('INNER JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function leftJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('LEFT JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function leftOuterJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('LEFT OUTER JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function rightJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('RIGHT JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function rightOuterJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('RIGHT OUTER JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function outerJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('OUTER JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function crossJoin($secondTable, $onClause = '')
    {
        return $this->realJoin('CROSS JOIN', $secondTable, $onClause);
    }

    /**
     * {@inheritDoc}
     */
    public function joinRaw(
        /*# string */ $joinType,
        /*# string */ $rawString,
        array $params = []
    ) {
    
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realJoin(strtoupper($joinType), $rawString, '', true);
    }

    /**
     * The real join
     *
     * @param  string $joinType
     * @param  string|string[]|SelectStatementInterface $secondTable
     * @param  string|string[]|ExpressionInterface $onClause
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realJoin(
        /*# string */ $joinType,
        $secondTable,
        $onClause = '',
        /*# bool */ $rawMode = false
    ) {
        $alias = 0; // no alias
        list($secondTable, $alias) = $this->fixJoinTable($secondTable);

        if ($rawMode || '' === $onClause || $this->isRaw($onClause, false)) {
            $rawMode = true;
        } else {
            $onClause = $this->fixOnClause($onClause);
        }
        $clause = &$this->getClause('JOIN');
        $clause[] = [$rawMode, $joinType, $secondTable, $alias, $onClause];
        return $this;
    }

    /**
     * Fix join table
     *
     * @param  string|string[]|SelectStatementInterface $table
     * @return array [table, alias]
     * @access protected
     */
    protected function fixJoinTable($table)
    {
        if (is_array($table)) {
            return $table;
        } elseif (is_object($table) && $table instanceof StatementInterface) {
            return [$table, uniqid()];
        } else {
            return [$table, 0]; // alias set 0
        }
    }

    /**
     * Fix 'ON' clause
     *
     * @param  mixed $onClause
     * @return array|ExpressionInterface
     * @access protected
     */
    protected function fixOnClause($onClause)
    {
        if (is_string($onClause)) {
            return [$onClause, '=', $onClause];
        } elseif (is_array($onClause) && !isset($onClause[2])) {
            return [$onClause[0], '=', $onClause[1]];
        } else {
            return $onClause;
        }
    }

    /**
     * Build join
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildJoin(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $string = '';
        $clause = &$this->getClause('JOIN');
        foreach ($clause as $cls) {
            $result = [];
            $prefix = $cls[1]; // join type
            $result[] = $this->buildJoinTable($cls, $settings); // join table
            if (!empty($cls[4])) {
                $result[] = $this->buildJoinOn($cls, $settings);
            }
            $string .= $this->joinClause($prefix, '', $result, $settings);
        }
        return $string;
    }

    /**
     * Build TABLE part
     *
     * @param  array $cls
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildJoinTable(array $cls, array $settings)/*# : string */
    {
        $table = $cls[2];
        $alias = $cls[3];
        return $this->quoteItem($table, $settings) . $this->quoteAlias($alias, $settings);
    }

    /**
     * Build ON part
     *
     * @param  array $cls
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildJoinOn(array $cls, array $settings)/*# : string */
    {
        $res = ['ON'];
        $on = $cls[4];
        if (is_string($on)) { // ON string
            $res[] = $on;
        } elseif (is_object($on)) { // ON is an object
            $res[] = $this->quoteItem($on, $settings);
        } else { // common on
            $res[] = $this->quote( // left
                $this->getFirstTableAlias($on[0]) . $on[0],
                $settings
            );
            $res[] = $on[1]; // operator
            $res[] = $this->quote( // right
                $this->getSecondTableAlias($cls, $on[2]) . $on[2],
                $settings
            );
        }
        return join(' ', $res);
    }

    /**
     * Get first table alias
     *
     * @param  string $left left part of eq
     * @return string
     * @access protected
     */
    protected function getFirstTableAlias(
        /*# string */ $left
    )/*# : string */ {
        if (false !== strpos($left, '.')) { // alias exists
            return '';
        } else { // prepend first table alias
            $tables = &$this->getClause('TABLE');
            reset($tables);
            $alias = key($tables);
            return (is_int($alias) ? $tables[$alias][0] : $alias) . '.';
        }
    }

    /**
     * Get second table alias
     *
     * @param  array $cls
     * @param  string $right right part of eq
     * @return string
     * @access protected
     */
    protected function getSecondTableAlias(
        array $cls,
        /*# string */ $right
    )/*# : string */ {
        if (false !== strpos($right, '.')) {
            return '';
        } else {
            $alias = $cls[3];
            if (!is_string($alias)) {
                $alias = $cls[2];
            }
            return $alias . '.';
        }
    }
}
