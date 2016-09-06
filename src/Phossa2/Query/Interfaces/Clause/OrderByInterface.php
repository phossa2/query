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
 * OrderByInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface OrderByInterface extends ClauseInterface
{
    /**
     * Generic ORDER BY ASC
     *
     * ```php
     * // ORDER BY `year` ASC, `month` ASC
     * ->orderBy('year')->orderBy('month')
     *
     * // ORDER BY `year` ASC, `month` ASC
     * ->orderBy(['year', 'month'])
     * ```
     *
     * @param  string|string[] $col
     * @param  bool $rawMode
     * @param  string $suffix 'ASC' or 'DESC'
     * @return $this
     * @access public
     * @api
     */
    public function orderBy(
        $col,
        /*# bool */ $rawMode = false,
        /*# sting */ $suffix = 'ASC'
    );

    /**
     * Generic ORDER BY DESC
     *
     * ```php
     * // ORDER BY `year` DESC
     * ->orderByDesc('year')
     *
     * // ORDER BY `year` DESC, `month` DESC
     * ->orderByDesc(['year', 'month'])
     * ```
     *
     * @param  string|string[] $col
     * @param  bool $rawMode
     * @return $this
     * @access public
     * @api
     */
    public function orderByDesc($col, /*# bool */ $rawMode = false);

    /**
     * ORDER BY template
     *
     * ```php
     * // ORDER BY `col` NULLS LAST DESC
     * ->orderByTpl('%s NULLS LAST DESC', 'col')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @return $this
     * @access public
     * @api
     */
    public function orderByTpl(/*# string */ $template, $col);

    /**
     * Raw mode ORDER BY
     *
     * ```php
     * // ORDER BY col NULLS LAST DESC
     * ->orderByRaw('col NULLS LAST DESC')
     * ```
     *
     * @param  string $rawString
     * @return $this
     * @access public
     * @api
     */
    public function orderByRaw(/*# string */ $rawString);
}
