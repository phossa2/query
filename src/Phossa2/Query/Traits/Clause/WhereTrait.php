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

use Phossa2\Query\Misc\Template;
use Phossa2\Query\Interfaces\Clause\WhereInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * WhereTrait
 *
 * Implementation of WhereInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     WhereInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait WhereTrait
{
    /**
     * {@inheritDoc}
     */
    public function where(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function whereTpl(/*# string */ $template, $col)
    {
        return $this->realWhere(new Template($template, $col),
            WhereInterface::NO_OPERATOR, WhereInterface::NO_VALUE,
            true, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereTpl(/*# string */ $template, $col)
    {
        return $this->realWhere(new Template($template, $col),
            WhereInterface::NO_OPERATOR, WhereInterface::NO_VALUE,
            false, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function whereRaw(/*# string */ $rawString)
    {
        return $this->realWhere($rawString, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, true, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereRaw(/*# string */ $rawString)
    {
        return $this->realWhere($rawString, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, false, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function andWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, true, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function whereIn(/*# string */ $col, $value)
    {
        return $this->realWhere($col, 'IN', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereIn(/*# string */ $col, $value)
    {
        return $this->realWhere($col, 'IN', $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotIn(/*# string */ $col, $value)
    {
        return $this->realWhere($col, 'NOT IN', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotIn(/*# string */ $col, $value)
    {
        return $this->realWhere($col, 'NOT IN', $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereBetween(/*# string */ $col, $value1, $value2)
    {
        $val = sprintf('%s AND %s', $value1, $value2);
        return $this->realWhere($col, 'BETWEEN', $val);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereBetween(/*# string */ $col, $value1, $value2)
    {
        $val = sprintf('%s AND %s', $value1, $value2);
        return $this->realWhere($col, 'BETWEEN', $val, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotBetween(/*# string */ $col, $value1, $value2)
    {
        $val = sprintf('%s AND %s', $value1, $value2);
        return $this->realWhere($col, 'NOT BETWEEN', $val);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotBetween(/*# string */ $col, $value1, $value2)
    {
        $val = sprintf('%s AND %s', $value1, $value2);
        return $this->realWhere($col, 'NOT BETWEEN', $val, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNull(/*# string */ $col)
    {
        return $this->realWhere($col, 'IS', 'NULL');
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNull(/*# string */ $col)
    {
        return $this->realWhere($col, 'IS', 'NULL', false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotNull(/*# string */ $col)
    {
        return $this->realWhere($col, 'IS', 'NOT NULL');
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotNull(/*# string */ $col)
    {
        return $this->realWhere($col, 'IS', 'NOT NULL', false);
    }

    /**
     * WHERE EXISTS
     *
     * ```php
     * // WHERE EXISTS (SELECT `user_id` FROM `users`)
     * ->whereExists($users->select('user_id'))
     * ```
     *
     * @param  SelectStatementInterface $sel
     * @return $this
     * @see    WhereInterface::where()
     * @access public
     * @api
     */
    public function whereExists(SelectStatementInterface $sel)
    {
        return $this->realWhere('', 'EXISTS', $sel);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereExists(SelectStatementInterface $sel)
    {
        return $this->realWhere('', 'EXISTS', $sel, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotExists(SelectStatementInterface $sel)
    {
        return $this->realWhere('', 'NOT EXISTS', $sel);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotExists(SelectStatementInterface $sel)
    {
        return $this->realWhere('', 'NOT EXISTS', $sel, false);
    }

    /**
     * Real where
     *
     * @param  string|string[]|Template $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @param  bool $logicAnd 'AND'
     * @param  bool $whereNot 'WHERE NOT'
     * @param  bool $rawMode
     * @param  string $clause 'where' or 'having'
     * @return $this
     * @access protected
     */
    protected function realWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode = false,
        /*# string */ $clause = 'WHERE'
    ) {
        $clause = &$this->getClause($clause);
        if (is_array($col)) {
            $this->multipleWhere($col, $logicAnd, $whereNot, $rawMode);
            return $this;
        }
        $this->fixOperatorValue($operator, $value, $rawMode);

        $clause[] = [$rawMode, $whereNot, $logicAnd, $col, $operator, $value];
        return $this;
    }

    /**
     * Fix operator and value
     *
     * @param  mixed $operator
     * @param  mixed $value
     * @param  bool $rawMode
     * @access protected
     */
    protected function fixOperatorValue(&$operator, &$value, &$rawMode)
    {
        if (WhereInterface::NO_OPERATOR === $operator) {
            $rawMode = true;
            $value = WhereInterface::NO_VALUE;
        } elseif (WhereInterface::NO_VALUE === $value) {
            $value = $operator;
            $operator = '=';
        }
    }

    /**
     * @param  array $cols
     * @param  bool $logicAnd
     * @param  bool $whereNot
     * @param  bool $rawMode
     * @access protected
     */
    protected function multipleWhere(
        array $cols,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false
    ) {
        foreach ($cols as $fld => $val) {
            if (is_array($val)) {
                $opr = $val[0];
                $val = $val[1];
            } else {
                $opr = '=';
            }
            $this->realWhere($fld, $opr, $val, $logicAnd, $whereNot, $rawMode);
        }
    }

    /**
     * Build WHERE
     *
     * @param  string $clause 'where|having'
     * @return array
     * @access protected
     */
    protected function buildWhere(
        array $settings,
        /*# string */ $clause = 'WHERE'
    )/*# : string */ {
        $result = [];
        $wheres = &$this->getClause($clause);
        foreach ($wheres as $idx => $where) {
            $cls = [];
            if ($idx) {
                $cls[] = $where[2] ? 'AND' : 'OR';
            }
            if ($where[1]) {
                $cls[] = 'NOT';
            }
            $result[] = $this->bulidWhereClause($cls, $where, $settings);
        }
        return $this->joinClause($clause, '', $result, $settings);
    }

    /**
     * Build 'col = val' part
     *
     * @param  array $cls
     * @param  array $where
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildWhereClause(array $cls, array $where, array $settings)
    {
        // col
        if (!empty($where[3])) {
            $cls[] = $this->quoteItem(
                $where[3], $settings, $this->isRaw($where[3], $where[0])
            );
        }

        // operator
        if (WhereInterface::NO_OPERATOR !== $where[4]) {
            $cls[] = $where[4];
        }

        // value
        if (WhereInterface::NO_VALUE !== $where[5]) {
            $cls[] = $this->processValue($where[5]);
        }

        return join(' ', $cls);
    }

    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function processValue($value)/*# : string */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function quoteItem($item, array $settings, /*# bool */ $rawMode = false)/*# : string */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
}
