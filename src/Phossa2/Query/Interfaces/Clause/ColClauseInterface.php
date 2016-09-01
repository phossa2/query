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
 * ColClauseInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ColClauseInterface extends ClauseInterface
{
    /**
     * Add col[s] to query
     *
     * ```php
     * // SELECT `user_name`
     * ->col('user_name')
     *
     * // SELECT `user_name` AS `n`
     * ->col('user_name', 'n')
     *
     * // SELECT `user_id`, `user_name`
     * ->col(['user_id', 'user_name'])
     *
     * // SELECT `user_id`, `user_name` AS `n`
     * ->col(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  mixed $col column specification[s]
     * @param  string $colAlias column alias name
     * @return $this
     * @access public
     * @api
     */
    public function col(
        $col,
        /*# string */ $colAlias = ''
    );

    /**
     * DISTINCT
     *
     * ```php
     * // SELECT DISTINCT `user_name`
     * ->distince()->col('user_name')
     *
     * // SELECT DISTINCT `user_name`
     * ->distinct('user_name')
     *
     * // SELECT DISTINCT `user_name` AS `n`
     * ->distinct('user_name', 'n')
     *
     * // SELECT DISTINCT `user_id`, `user_name`
     * ->distinct(['user_id', 'user_name'])
     * ```
     *
     * @param  mixed $col column specification[s]
     * @param  string $colAlias column alias name
     * @return $this
     * @access public
     * @api
     */
    public function distinct(
        $col = '',
        /*# string */ $colAlias = ''
    );

    /**
     * Raw mode col
     *
     * ```php
     * // SELECT COUNT(user_id) AS cnt
     * ->colRaw('COUNT(user_id)', 'cnt')
     * ```
     *
     * @param  string $string
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function colRaw(/*# string */ $string, /*# string */ $alias = '');
}
