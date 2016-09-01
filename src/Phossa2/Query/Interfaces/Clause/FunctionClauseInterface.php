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
 * FunctionClauseInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface FunctionClauseInterface extends ClauseInterface
{
    /**
     * Use function template with col
     *
     * ```php
     * // SELECT CONCAT(`user_name`, "XXX") AS `new_name` FROM `users`
     * $users->select()->func('CONCAT(%s, "XXX")', 'user_name', 'new_name');
     * ```
     *
     * @param  string $function function template with lots of '%s'
     * @param  string|string[] $cols col or array of cols
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function func(/*# string */ $function, $col, /*# string */ $alias = '');

    /**
     * COUNT()
     *
     * ```php
     * // SELECT COUNT(`user_id`) AS `cnt`
     * select()->count('user_id', 'cnt')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function count(/*# string */ $col, /*# string */ $alias = '');

    /**
     * MIN()
     *
     * ```php
     * // SELECT MIN(`score`) AS `min_score`
     * select()->min('score', 'min_score')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function min(/*# string */ $col, /*# string */ $alias = '');

    /**
     * MAX()
     *
     * ```php
     * // SELECT MAX(`score`) AS `max_score`
     * select()->max('score', 'max_score')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function max(/*# string */ $col, /*# string */ $alias = '');

    /**
     * AVG()
     *
     * ```php
     * // SELECT AVG(`score`) AS `avg_score`
     * select()->avg('score', 'avg_score')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function avg(/*# string */ $col, /*# string */ $alias = '');

    /**
     * SUM()
     *
     * ```php
     * // SELECT SUM(`score`) AS `total_score`
     * select()->sum('score', 'total_score')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function sum(/*# string */ $col, /*# string */ $alias = '');

    /**
     * SUM(DISTINCT)
     *
     * ```php
     * // SELECT SUM(DISTINCT `score`) AS `s`
     * select()->sumDistinct('score', 's')
     * ```
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function sumDistinct(/*# string */ $col, /*# string */ $alias = '');
}
