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
    use AbstractTrait;

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
    public function whereTpl(/*# string */ $template, $col, array $params = [])
    {
        $template = $this->positionedParam($template, $params);
        return $this->realWhere(
            new Template($template, $col),
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            'AND',
            ''
        );
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereTpl(/*# string */ $template, $col, array $params = [])
    {
        $template = $this->positionedParam($template, $params);
        return $this->realWhere(
            new Template($template, $col),
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            'OR',
            ''
        );
    }

    /**
     * {@inheritDoc}
     */
    public function whereRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realWhere(
            $rawString,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            'AND',
            '',
            true
        );
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realWhere(
            $rawString,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            'OR',
            '',
            true
        );
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
        return $this->realWhere($col, $operator, $value, 'OR');
    }

    /**
     * {@inheritDoc}
     */
    public function whereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, 'AND', 'NOT');
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, 'OR', 'NOT');
    }

    /**
     * Real where
     *
     * @param  string|string[]|Template $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @param  string $logicAnd 'AND'
     * @param  string $whereNot 'WHERE NOT'
     * @param  bool $rawMode
     * @param  string $clause 'where' or 'having'
     * @return $this
     * @access protected
     */
    protected function realWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE,
        /*# string */ $logicAnd = 'AND',
        /*# string */ $whereNot = '',
        /*# bool */ $rawMode = false,
        /*# string */ $clause = 'WHERE'
    ) {
        $clause = &$this->getClause($clause);
        if (is_array($col)) {
            $this->multipleWhere($col, $logicAnd, $whereNot, $rawMode);
            return $this;
        }
        // fix raw mode
        $rawMode = $this->isRaw($col, $rawMode);
        // fix operator to '='
        $this->fixOperator($operator, $value, $rawMode);
        $clause[] = [$rawMode, $whereNot, $logicAnd, $col, $operator, $value];
        return $this;
    }

    /**
     * @param  array $cols
     * @param  string $logicAnd
     * @param  string $whereNot
     * @param  bool $rawMode
     * @access protected
     */
    protected function multipleWhere(
        array $cols,
        /*# string */ $logicAnd = 'AND',
        /*# string */ $whereNot = '',
        /*# bool */ $rawMode = false
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
     * Fix where('id', 18) to where('id', '=', 18)
     *
     * @param  mixed &$operator
     * @param  mixed &$value
     * @param  bool $rawMode
     * @access protected
     */
    protected function fixOperator(&$operator, &$value, $rawMode)
    {
        if (!$rawMode && WhereInterface::NO_VALUE === $value) {
            $value = $operator;
            $operator = '=';
        }
    }

    /**
     * Build WHERE
     *
     * @param  prefix
     * @param  array $settings
     * @return array
     * @access protected
     */
    protected function buildWhere(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $result = [];
        if ('HAVING' === $prefix) {
            $wheres = &$this->getClause($prefix);
        } else {
            $wheres = &$this->getClause('WHERE');
        }
        foreach ($wheres as $idx => $where) {
            $cls = [];
            // build AND part
            $this->buildAndOr($cls, $where, $idx);
            // build COL = VAL
            $result[] = $this->buildCondition($cls, $where, $settings);
        }
        return $this->joinClause($prefix, '', $result, $settings);
    }

    /**
     * build 'AND NOT' part of the clause part
     *
     * @param  array &$cls
     * @param  array $where
     * @param  int $idx
     * @access protected
     */
    protected function buildAndOr(array &$cls, array $where, $idx)
    {
        // AND OR
        if ($idx) {
            $cls[] = $where[2];
        }
        // NOT
        if ($where[1]) {
            $cls[] = $where[1];
        }
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
    protected function buildCondition(array $cls, array $where, array $settings)
    {
        if (!empty($where[3])) {
            $cls[] = $this->quoteItem(
                $where[3],
                $settings,
                $this->isRaw($where[3], $where[0])
            );
        }
        if (WhereInterface::NO_OPERATOR !== $where[4]) {
            $cls[] = $where[4];
        }
        if (WhereInterface::NO_VALUE !== $where[5]) {
            $cls[] = $this->processValue(
                $where[5],
                $settings,
                (bool) preg_match('/\bbetween\b/i', $where[4])
            );
        }
        return join(' ', $cls);
    }
}
