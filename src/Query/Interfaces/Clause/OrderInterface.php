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
 * OrderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface OrderInterface extends ClauseInterface
{
    /**
     * Generic ORDER BY ASC
     *
     * ```php
     * // ORDER BY `year` ASC, `month` ASC
     * ->order('year')->order('month')
     *
     * // same as above
     * ->order('year', 'month')
     *
     * // same as above
     * ->order(['year', 'month'])
     * ```
     *
     * @param  string|string[] $col
     * @return $this
     * @access public
     * @api
     */
    public function order($col);

    /**
     * Generic ORDER BY DESC
     *
     * ```php
     * // ORDER BY `year` DESC, `month` DESC
     * ->orderDesc('year')->orderDesc('month')
     *
     * // same as above
     * ->orderDesc('year', 'month')
     *
     * // same as above
     * ->orderDesc(['year', 'month'])
     * ```
     *
     * @param  string|string[] $col
     * @return $this
     * @access public
     * @api
     */
    public function orderDesc($col);

    /**
     * ORDER BY template
     *
     * ```php
     * // ORDER BY `col` NULLS LAST DESC
     * ->orderTpl('%s NULLS LAST DESC', 'col')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function orderTpl(/*# string */ $template, $col, array $params = []);

    /**
     * Raw mode ORDER BY
     *
     * Support second param as positioned param
     * ```php
     * // ORDER BY col NULLS LAST DESC
     * ->orderRaw('col NULLS LAST DESC')
     *
     * // ORDER BY age + 10
     * ->orderRaw('age + ?', [10])
     * ```
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function orderRaw(/*# string */ $rawString, array $params = []);
}
