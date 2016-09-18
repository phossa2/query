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
 * ColInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ColInterface extends ClauseInterface
{
    /**
     * Add col[s] to query
     *
     * ```php
     * // SELECT `user_id`, `user_name`
     * ->col('user_id')->col('user_name')
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
     * @param  string|array $col column/field specification[s]
     * @param  string $alias column alias name
     * @return $this
     * @access public
     * @api
     */
    public function col($col = '', /*# string */ $alias = '');

    /**
     * DISTINCT
     *
     * With variable col names
     *
     * ```php
     * // SELECT DISTINCT `user_name`
     * ->distince()->col('user_name')
     *
     * // SELECT DISTINCT `user_name`
     * ->distinct('user_name')
     *
     * // SELECT DISTINCT `user_id`, `user_name`
     * ->distinct('user_id', 'user_name')
     * ```
     *
     * @return $this
     * @access public
     * @api
     */
    public function distinct();

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
     * Provides a templated field specifications
     *
     * ```php
     * // SELECT CONCAT(`firstname`, ' ', `surname`) AS `n`
     * ->colTpl('CONCAT(%s, ' ', %s)', ['firstname', 'surname'], 'n')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @param  string $alias
     * @return $this
     * @access public
     * @api
     */
    public function colTpl(/*# string */ $template, $col, /*# string */ $alias = '');

    /**
     * Raw mode col
     *
     * Support second param as positioned param
     * ```php
     * // SELECT COUNT(user_id) AS cnt
     * ->colRaw('COUNT(user_id) AS cnt')
     *
     * // SELECT SUM(score + 10)
     * ->colRaw('SUM(score + ?)', [10])
     * ```
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function colRaw(/*# string */ $rawString, array $params = []);
}
