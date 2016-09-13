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
use Phossa2\Query\Interfaces\Clause\GroupByInterface;

/**
 * GroupByTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     GroupByInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait GroupByTrait
{
    /**
     * {@inheritDoc}
     */
    public function groupBy($col)
    {
        // support multiple group by
        if (func_num_args() > 1) {
            $col = func_get_args();
        }
        return $this->realGroupBy($col);
    }

    /**
     * {@inheritDoc}
     */
    public function groupByTpl(/*# string */ $template, $col)
    {
        return $this->realGroupBy(new Template($template, $col), true);
    }

    /**
     * {@inheritDoc}
     */
    public function groupByRaw(/*# string */ $groupby)
    {
        return $this->realGroupBy($groupby, true);
    }

    /**
     * real group by
     * @param  string|string[]|Template $col column[s]
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realGroupBy($col, /*# bool */ $rawMode = false)
    {
        if (is_array($col)) {
            $this->multipleGroupBy($col);
        } else {
            $clause = &$this->getClause('GROUP BY');
            $clause[] = [$col, $this->isRaw($col, $rawMode)];
        }
        return $this;
    }

    /**
     * Multitple groupbys
     *
     * @param  array $cols
     * @access protected
     */
    protected function multipleGroupBy(array $cols)
    {
        foreach ($cols as $col) {
            $this->realGroupBy($col);
        }
    }

    /**
     * Build GROUP BY
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildGroupby(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('GROUP BY', 'GROUP BY', $settings);
    }

    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function buildClause(
        /*# string */ $clauseName,
        /*# string */ $clausePrefix,
        array $settings,
        array $clauseParts = []
    )/*# string */;
}
