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

use Phossa2\Query\Interfaces\ClauseInterface;
use Phossa2\Query\Interfaces\Clause\OnInterface;
use Phossa2\Query\Interfaces\ExpressionInterface;

/**
 * OnTrait
 *
 * Implementation of OnInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OnInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait OnTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function on(
        $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
    ) {
        return $this->realOn($firstTableCol, $operator, $secondTableCol);
    }

    /**
     * {@inheritDoc}
     */
    public function orOn(
        $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
    ) {
        return $this->realOn($firstTableCol, $operator, $secondTableCol, true);
    }

    /**
     * {@inheritDoc}
     */
    public function onRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realOn($rawString);
    }

    /**
     * {@inheritDoc}
     */
    public function orOnRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realOn(
            $rawString,
            ClauseInterface::NO_OPERATOR,
            ClauseInterface::NO_VALUE,
            true
        );
    }

    /**
     * @param  string|ExpressionInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @param  bool $or
     * @return $this
     * @access protected
     */
    protected function realOn(
        $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE,
        /*# bool */ $or = false
    ) {
        if (is_object($firstTableCol)) {
            $on = [$or, $firstTableCol];
        } elseif (ClauseInterface::NO_OPERATOR === $operator) {
            $on = [$or, $firstTableCol, '=', $firstTableCol];
        } elseif (ClauseInterface::NO_VALUE === $secondTableCol) {
            $on = [$or, $firstTableCol, '=', $operator];
        } else {
            $on = [$or, $firstTableCol, $operator, $secondTableCol];
        }
        $clause = &$this->getClause('ON');
        $clause[] = $on;

        return $this;
    }

    /**
     * Build ON
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildOn(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $result = [];
        $clause = &$this->getClause('ON');
        foreach ($clause as $idx => $on) {
            $res = [];
            if (is_object($on[1])) {
                $res[] = $this->quoteItem($on[1], $settings);
            } else {
                $res[] = $this->quote($on[1], $settings); // first col
                $res[] = $on[2]; // operator
                $res[] = $this->quote($on[3], $settings); // second col
            }
            $result[] = $this->onOrAnd($idx, $on[0]) . join(' ', $res);
        }
        return trim($this->joinClause($prefix, '', $result, $settings));
    }

    /**
     * Prepend OR or AND
     *
     * @param  int $index
     * @param  bool $or
     * @return string
     * @access protected
     */
    protected function onOrAnd(/*# int */ $index, /*# bool */ $or)
    {
        return $index ? ($or ? 'OR ' : 'AND ' ) : '';
    }
}
