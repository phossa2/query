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
 * ExtraClauseInterface
 *
 * Add extra raw string before/after one clause
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ExtraClauseInterface extends ClauseInterface
{
    /**
     * Add before anther $clause
     *
     * Support third param as positioned param
     *
     * ```php
     * // insert PARTITION before WHERE
     * ->before('where', 'PARTITION (part1, part2)')
     *
     * // INTO OUTFILE 'test.txt'
     * ->after('limit', 'INTO OUTFILE ?', ['test.txt'])
     * ```
     *
     * @param  string $position such as 'COL', 'TABLE'
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function before(
        /*# string */ $position,
        /*# string */ $rawString,
        array $params = []
    );

    /**
     * Add after anther $clause
     *
     * ```php
     * // LIMIT 10 FOR UPDATE
     * ->after('limit', 'FOR UPDATE');
     * ```
     *
     * @param  string $position such as 'COL', 'TABLE'
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function after(
        /*# string */ $position,
        /*# string */ $rawString,
        array $params = []
    );

    /**
     * Hint follows the statement. e.g. 'INSERT DELAYED'
     *
     * ```php
     * $builder->insert()->hint('DELAYED')->set(...)
     * ```
     *
     * @param  string $hintString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function hint(/*# string */ $hintString, array $params = []);

    /**
     * String at the statement end
     *
     * ```php
     * // SELECT ... FOR UPDATE
     * $builder->select()->option('FOR UPDATE');
     *
     * @param  string $optionString
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function option(/*# string */ $optionString, array $params = []);
}
