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

namespace Phossa2\Query\Interfaces\Clause;

use Phossa2\Query\Interfaces\ClauseInterface;

/**
 * GroupByInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface GroupByInterface extends ClauseInterface
{
    /**
     * Generic GROUP BY
     *
     * ```php
     * // GROUP BY `year`
     * ->groupBy('year')
     *
     * // GROUP BY `year`, `gender`
     * ->groupBy(['year', 'gender'])
     * ```
     *
     * @param  string|string[] $col column[s]
     * @param  bool $rawMode
     * @return $this
     * @access public
     * @api
     */
    public function groupBy($col, /*# bool */ $rawMode = false);

    /**
     * Generic GROUP BY template
     *
     * ```php
     * // GROUP BY `year` WITH ROLLUP
     * ->groupByTpl('%s WITH ROLLUP', 'year')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @return $this
     * @access public
     * @api
     */
    public function groupByTpl(/*# string */ $template, $col);

    /**
     * Generic GROUP BY Raw mode
     *
     * ```php
     * // GROUP BY year WITH ROLLUP
     * ->groupByRaw('year WITH ROLLUP')
     * ```
     *
     * @param  string $groupby
     * @return $this
     * @access public
     * @api
     */
    public function groupByRaw(/*# string */ $groupby);
}
