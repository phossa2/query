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
use Phossa2\Query\Interfaces\Clause\OrderInterface;

/**
 * OrderTrait
 *
 * Implementation of OrderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OrderInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait OrderTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function order($col)
    {
        if (func_num_args() > 1) {
            $col = func_get_args();
        }
        return $this->realOrder($col, 'ASC');
    }

    /**
     * {@inheritDoc}
     */
    public function orderDesc($col)
    {
        if (func_num_args() > 1) {
            $col = func_get_args();
        }
        return $this->realOrder($col, 'DESC');
    }

    /**
     * {@inheritDoc}
     */
    public function orderTpl(/*# string */ $template, $col, array $params = [])
    {
        $template = $this->positionedParam($template, $params);
        return $this->realOrder(new Template($template, $col), '', true);
    }

    /**
     * {@inheritDoc}
     */
    public function orderRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realOrder($rawString, '', true);
    }

    /**
     * Real orderby
     *
     * @param  string|string[]|Template $col
     * @param  string $suffix 'ASC' or 'DESC'
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realOrder(
        $col,
        /*# sting */ $suffix = 'ASC',
        /*# bool */ $rawMode = false
    ) {
        if (is_array($col)) {
            $this->multipleOrder($col, $suffix);
        } else {
            $clause = &$this->getClause('ORDER BY');
            $part = [$col, $this->isRaw($col, $rawMode)];
            if (!empty($suffix)) {
                $part[] = $suffix;
            }
            $clause[] = $part;
        }
        return $this;
    }

    /**
     * Multitple orderbys
     *
     * @param  array $cols
     * @param  string $suffix 'ASC' or 'DESC'
     * @access protected
     */
    protected function multipleOrder(array $cols, /*# sting */ $suffix)
    {
        foreach ($cols as $col) {
            $this->realOrder($col, $suffix);
        }
    }

    /**
     * Build ORDER BY
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildOrder(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('ORDER BY', $prefix, $settings);
    }
}
