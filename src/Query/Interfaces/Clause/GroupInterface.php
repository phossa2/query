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
 * GroupInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface GroupInterface extends ClauseInterface
{
    /**
     * Generic GROUP BY
     *
     * Support variable parameters
     *
     * ```php
     * // GROUP BY `year`
     * ->group('year')
     *
     * // GROUP BY `age`, `gender`
     * ->group('age', 'gender')
     *
     * // GROUP BY `year`, `gender`
     * ->group(['year', 'gender'])
     * ```
     *
     * @param  string|string[] $col column[s]
     * @return $this
     * @access public
     * @api
     */
    public function group($col);

    /**
     * Generic GROUP BY DESC
     *
     * ```php
     * // GROUP BY `year` DESC
     * ->groupDesc('year')
     *
     * // GROUP BY `year` DESC, `gender` DESC
     * ->groupDesc(['year', 'gender'])
     * ```
     *
     * @param  string|string[] $col column[s]
     * @return $this
     * @access public
     * @api
     */
    public function groupDesc($col);

    /**
     * Generic GROUP BY template
     *
     * ```php
     * // GROUP BY `year` WITH ROLLUP
     * ->groupTpl('%s WITH ROLLUP', 'year')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function groupTpl(/*# string */ $template, $col, array $params = []);

    /**
     * Generic GROUP BY Raw mode
     *
     * Support second parameter as positioned param
     *
     * ```php
     * // GROUP BY year WITH ROLLUP
     * ->groupRaw('year WITH ROLLUP')
     *
     * // GROUP BY year + 10
     * ->groupRaw('year + ?', [10])
     * ```
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function groupRaw(/*# string */ $rawString, array $params = []);
}
