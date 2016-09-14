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
 * ExtraInterface
 *
 * Add extra raw string before/after one clause
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ExtraInterface extends ClauseInterface
{
    /**
     * Add before anther $clause
     *
     * ```php
     * // insert PARTITION before WHERE
     * ->before('where', 'PARTITION (part1, part2)')
     * ```
     *
     * @param  string $position such as 'COL', 'FROM'
     * @param  string $rawString
     * @return $this
     * @access public
     * @api
     */
    public function before(/*# string */ $position, /*# string */ $rawString);

    /**
     * Add after anther $clause
     *
     * ```php
     * // LIMIT 10 FOR UPDATE
     * ->after('limit', 'FOR UPDATE');
     * ```
     *
     * @param  string $position such as 'COL', 'FROM'
     * @param  string $rawString
     * @return $this
     * @access public
     * @api
     */
    public function after(/*# string */ $position, /*# string */ $rawString);
}
