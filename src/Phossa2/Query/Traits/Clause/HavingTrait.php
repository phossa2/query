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

use Phossa2\Query\Interfaces\Clause\WhereInterface;
use Phossa2\Query\Interfaces\Clause\HavingInterface;

/**
 * HavingTrait
 *
 * Implementation of HavingInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     HavingInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait HavingTrait
{
    /**
     * {@inheritDoc}
     */
    public function having(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE
    ) {
        return $this->realWhere($col, $operator, $value, true, false, false, 'HAVING');
    }

    /**
     * {@inheritDoc}
     */
    public function havingTpl(/*# string */ $template, $col)
    {
        return $this->realWhere($this->clauseTpl($template, $col),
            WhereInterface::NO_OPERATOR, WhereInterface::NO_VALUE,
            true, false, true, 'HAVING');
    }

    /**
     * {@inheritDoc}
     */
    public function havingRaw(/*# string */ $rawString)
    {
        return $this->realWhere($rawString, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, true, false, true, 'HAVING');
    }

    /**
     * Build HAVING
     *
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildHaving(array $settings)/*# : string */
    {
        return $this->buildWhere($settings, 'HAVING');
    }

    abstract protected function buildWhere(
        array $settings,
        /*# string */ $clause = 'WHERE'
    )/*# : array */;
    abstract protected function realWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false,
        /*# string */ $clause = 'WHERE'
    );
    abstract protected function clauseTpl(/*# string */ $template, $col)/*# : string */;
}
