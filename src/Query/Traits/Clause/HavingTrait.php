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
    use AbstractTrait;

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
    public function havingTpl(/*# string */ $template, $col, array $params = [])
    {
        $template = $this->positionedParam($template, $params);
        return $this->realWhere(
            new Template($template, $col),
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            true,
            false,
            true,
            'HAVING'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function havingRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realWhere(
            $rawString,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            true,
            false,
            true,
            'HAVING'
        );
    }

    /**
     * Build HAVING
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildHaving(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildWhere($prefix, $settings);
    }

    // in WhereTrait
    abstract protected function buildWhere(
        /*# string */ $prefix,
        array $settings
    )/*# : string */;
    abstract protected function realWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value = WhereInterface::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode = false,
        /*# string */ $clause = 'WHERE'
    );
}
