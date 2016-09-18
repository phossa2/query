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
use Phossa2\Query\Interfaces\Clause\ColInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * ColTrait
 *
 * Implementation of ColInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ColInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait ColTrait
{
    use AbstractTrait;

    /**
     * @var    bool
     * @access protected
     */
    protected $is_distinct = false;

    /**
     * {@inheritDoc}
     */
    public function col($col = '', /*# string */ $alias = '')
    {
        return $this->realCol($col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function distinct()
    {
        $this->is_distinct = true;
        return $this->col(func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function count(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->colTpl('COUNT(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function min(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->colTpl('MIN(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function max(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->colTpl('MAX(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function avg(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->colTpl('AVG(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function sum(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->colTpl('SUM(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function colTpl(
        /*# string */ $template,
        $col,
        /*# string */ $alias = ''
    ) {
        return $this->realCol(new Template($template, $col), $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function colRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realCol($rawString, '', true);
    }

    /**
     * @param  mixed $col column/field specification[s]
     * @param  string $alias column alias name
     * @param  bool $rawMode raw mode
     */
    protected function realCol(
        $col,
        /*# string */ $alias = '',
        $rawMode = false
    ) {
        if (empty($col)) {
            return $this;
        } elseif (is_array($col)) {
            $this->multipleCol($col, $rawMode);
        } else {
            $clause = &$this->getClause('COL');
            $raw = $this->isRaw($col, $rawMode);
            if ('' === $alias) {
                $clause[] = [$col, $raw];
            } else {
                $clause[(string) $alias] = [$col, $raw];
            }
        }
        return $this;
    }

    /**
     * from multiple tables
     *
     * @param  array $cols
     * @param  bool $rawMode
     * @access protected
     */
    protected function multipleCol(array $cols, /*# bool */ $rawMode)
    {
        foreach ($cols as $key => $val) {
            if (is_int($key)) {
                $this->realCol($val, '', $rawMode);
            } else {
                $this->realCol($key, $val, $rawMode);
            }
        }
    }

    /**
     * Build fields
     *
     * @param  strin $prefix prefix afront of the clause
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildCol(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $clause = &$this->getClause('COL');
        if ($this instanceof SelectStatementInterface && empty($clause)) {
            $clauseParts = ['*'];
        } else {
            $clauseParts = [];
        }
        return $this->buildClause('COL', $prefix, $settings, $clauseParts);
    }

    /**
     * Build DISTINCT
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildDistinct(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->is_distinct ? ' DISTINCT' : $prefix;
    }
}
