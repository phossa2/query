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
    /**
     * {@inheritDoc}
     */
    public function join($secondTable, $onClause = '', $firstTable = '')
    {
        return $this->realJoin('INNER JOIN', $secondTable, $onClause, $firstTable);
    }

    /**
     * {@inheritDoc}
     */
    public function leftJoin($secondTable, $onClause = '', $firstTable = '')
    {
        return $this->realJoin('LEFT JOIN', $secondTable, $onClause, $firstTable);
    }

    /**
     * {@inheritDoc}
     */
    public function joinRaw(/*# string */ $joinType, /*# string */ $rawString)
    {
        return $this->realJoin($joinType, $rawString, '', '', true);
    }

    /**
     * The real join
     *
     * @param  string $joinType
     * @param  string|string[]|SelectStatementInterface $secondTable
     * @param  string|string[]|ExpressionInterface $onClause
     * @param  string $firstTable
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realJoin(
        /*# string */ $joinType,
        $secondTable,
        $onClause = '',
        $firstTable = '',
        /*# bool */ $rawMode = false
    ) {
        $alias = 0; // no alias
        if ($rawMode || '' === $onClause) { // raw mode
            $rawMode = true;
        }
        if (!$rawMode) { // fix table/alias/on
            $onClause = $this->fixOnClause($onClause);
            list($secondTable, $alias) = $this->fixJoinTable($secondTable);
        }
        $clause = &$this->getClause('JOIN');
        $clause[] = [$rawMode, $joinType, $secondTable, $alias, $onClause, $firstTable];
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
        if (is_object($table)) {
            return [$table, uniqid()]; // need an alias
        } elseif (is_string($table)) {
            return [$table, 0]; // alias set 0
        } else {
            return $table; // array
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
            if ($cls[0]) { // raw mode
                $result[] = $cls[2];
            } else {
                $result[] = $this->buildJoinTable($cls, $settings);
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
        $on = $cls[4];
        $res = ['ON'];

        if (is_object($on)) {
            $res[] = $on->getStatement($settings);
        } else {
            // first
            $res[] = $this->quote($this->getFirstTableAlias($cls) . $on[0], $settings);
            // operator
            $res[] = $on[1];
            // second
            $res[] = $this->quote($this->getSecondTableAlias($cls) . $on[2], $settings);
        }
        return join(' ', $res);
    }

    /**
     * Get first table alias
     *
     * @param  array $cls
     * @return string
     * @access protected
     */
    protected function getFirstTableAlias(array $cls)/*# : string */
    {
        // first table specified
        if (!empty($cls[5])) {
            return $cls[5] . '.';
        } else {
            $tables = &$this->getClause('FROM');
            reset($tables);
            $alias = key($tables);
            return (is_int($alias) ? $tables[$alias][0] : $alias) . '.';
        }
    }

    /**
     * Get second table alias
     *
     * @param  array $cls
     * @return string
     * @access protected
     */
    protected function getSecondTableAlias(array $cls)/*# : string */
    {
        $alias = $cls[3];
        if (!is_string($alias)) {
            $alias = $cls[2];
        }
        return $alias . '.';
    }

    abstract protected function quote(/*# string */ $str, array $settings)/*# : string */;
    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function flatSettings(array $settings)/*# : array */;
    abstract protected function quoteItem(
        $item,
        array $settings,
        /*# bool */ $rawMode = false
    )/*# : string */;
    abstract protected function quoteAlias($alias, array $settings)/*# : string */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
}
