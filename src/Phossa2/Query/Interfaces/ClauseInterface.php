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

namespace Phossa2\Query\Interfaces;

/**
 * ClauseInterface
 *
 * Marker for clause related interfaces
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ClauseInterface
{
    /**
     * Dummy placeholders
     *
     * @var    string
     */
    const NO_VALUE = '__NO_SUCH_VALUE__';
    const SHORT_FORM = '__SHORT_FORM__';
    const NO_OPERATOR = '__NO_SUCH_OPERATOR__';

    /**
     * Create a clause with template and cols
     *
     * ```php
     * // GROUP BY `year` WITH ROLLUP
     * ->clauseTpl('GROUP BY', '%s WITH ROLLUP', 'year')
     *
     * // CONCAT(`firstname`, ' ', `surname`) AS `n`
     * ->clauseTpl('COL', 'CONCAT(%s, ' ', %s)', ['firstname', 'surname'], 'n')
     * ```
     *
     * @param  string $clause e.g. 'GROUP BY'
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @param  string $alias
     * @access public
     */
    public function clauseTpl(
        /*# string */ $clause,
        /*# string */ $template,
        $col,
        /*# string */ $alias = ''
    );

    /**
     * Create a raw clause
     *
     * ```php
     * // GROUP BY year WITH ROLLUP
     * ->clauseRaw('GROUP BY', 'year WITH ROLLUP')
     *
     * // CONCAT(firstname, " ", surname) AS `n`
     * ->clauseRaw('COL', 'CONCAT(firstname, " ", surname)', 'n')
     * ```
     *
     * @param  string $clause e.g. 'GROUP BY'
     * @param  string $rawString
     * @param  string $alias alias name if any
     * @access public
     */
    public function clauseRaw(
        /*# string */ $clause,
        /*# string */ $rawString,
        /*# string */ $alias = ''
    );
}
