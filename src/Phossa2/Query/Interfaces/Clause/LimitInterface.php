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
 * LimitInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface LimitInterface extends ClauseInterface
{
    /**
     * Limit return rows, if $count is -1, means to the end
     *
     * ```php
     * // LIMIT 10 OFFSET 20
     * ->limit(10, 20)
     * ```
     *
     * @param  int $count
     * @param  int $offset
     * @return $this
     * @access public
     * @api
     */
    public function limit(/*# int */ $count, /*# int */ $offset = 0);

    /**
     * Offset
     *
     * ```php
     * // LIMIT 10 OFFSET 20
     * ->limit(10)->offset(20)
     * ```
     *
     * @param  int $offset
     * @return $this
     * @access public
     * @api
     */
    public function offset(/*# int */ $offset);

    /**
     * Paging
     *
     * ```php
     * // LIMIT 30 OFFSET 0
     * ->page(1)
     * ```
     *
     * @param  int $pageNumber start from 1
     * @param  int $perPage rows per page
     * @return $this
     * @access public
     * @api
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30);
}
