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
 * UpdateInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UpdateInterface extends ClauseInterface
{
    /**
     * Increment a column value by a step
     *
     * @param  string $col
     * @param  int $step
     * @access public
     * @api
     */
    public function increment(/*# string */ $col, /*# int */ $step = 1);

    /**
     * Decrement a column value by a step
     *
     * @param  string $col
     * @param  int $step
     * @access public
     * @api
     */
    public function decrement(/*# string */ $col, /*# int */ $step = 1);
}
