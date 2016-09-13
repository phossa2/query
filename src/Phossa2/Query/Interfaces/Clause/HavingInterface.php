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
use Phossa2\Query\Interfaces\ExpressionInterface;

/**
 * HavingInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface HavingInterface extends ClauseInterface
{
    /**
     * Generic HAVING
     *
     * ```php
     * // HAVING `count` = 10
     * ->having('count', 10)
     *
     * // HAVING `count` > 10
     * ->having('count', '>', 10)
     *
     * // auto raw mode
     * ->having('count > 10')
     * ```
     *
     * @param  string|string[]|ExpressionInterface $col
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @access public
     * @api
     */
    public function having($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);

    /**
     * HAVING template
     *
     * ```php
     * // HAVNIG `count` = 10
     * ->havingTpl('%s = 10', 'count')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @return $this
     * @access public
     * @api
     */
    public function havingTpl(/*# string */ $template, $col);

    /**
     * Raw mode Having
     *
     * ```php
     * // HAVNIG count = 10
     * ->havingRaw('count = ?', [10])
     * ```
     *
     * @param  string $rawString
     * @return $this
     * @access public
     * @api
     */
    public function havingRaw(/*# string */ $rawString);
}
