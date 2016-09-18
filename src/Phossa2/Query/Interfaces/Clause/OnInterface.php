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
 * OnInterface
 *
 * Used in Expression
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface OnInterface extends ClauseInterface
{
    /**
     * ON
     *
     * @param  string|ExpressionInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     * @api
     */
    public function on(
        $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
    );

    /**
     * OR ON
     *
     * @param  string|ExpressionInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     * @api
     */
    public function orOn(
        $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
    );

    /**
     * Raw mode ON
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function onRaw(/*# string */ $rawString, array $params = []);

    /**
     * Raw mode OR ON
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function orOnRaw(/*# string */ $rawString, array $params = []);
}
