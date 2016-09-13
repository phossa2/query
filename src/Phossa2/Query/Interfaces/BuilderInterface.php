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

use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * BuilderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @see     SettingsInterface
 * @see     FromInterface
 * @see     ParameterAwareInterface
 * @see     PreviousInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsInterface, FromInterface, ParameterAwareInterface, PreviousInterface
{
    /**
     * Create an expression
     *
     * ```php
     * $users = new Builder('Users', new Mysql());
     *
     * // SELECT *
     * //     FROM Users
     * //     WHERE
     * //         (age < 18 OR gender = 'female') OR
     * //         (age > 60 OR (age > 55 AND gender = 'female'))
     * $users->select()
     *   ->where(
     *     $users->expr()->where('age', '<', 18)->orWhere('gender', 'female')
     *   )->orWhere(
     *     $users->expr()->where('age', '>' , 60)->orWhere(
     *       $users->where('age', '>', 55)->where('gender', 'female')
     *     )
     *   );
     * ```
     *
     * @return ExpressionInterface
     * @access public
     * @api
     */
    public function expr()/*# : ExpressionInterface */;

    /**
     * Pass as raw, do NOT quote
     *
     * ```php
     * $builder->select()->col($builder->raw('RANGE(?, ?)', 1, 10));
     * ```
     *
     * @param  string $string
     * @return RawInterface
     * @access public
     * @api
     */
    public function raw(/*# string */ $string)/*# : RawInterface */;

    /**
     * Build a SELECT statement
     *
     * Add col[s] to SELECT query.
     *
     * ```php
     * // SELECT DISTINCT
     * ->select()->distinct()
     *
     * // SELECT `user_name`
     * ->select('user_name')
     *
     * // SELECT `user_name` AS `n`
     * ->select('user_name', 'n')
     *
     * // SELECT `user_id`, `user_name`
     * ->select(['user_id', 'user_name'])
     *
     * // SELECT `user_id`, `user_name` AS `n`
     * ->select(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  string|array $col column specification[s]
     * @param  string $alias alias name for $col
     * @return SelectStatementInterface
     * @access public
     * @throws BadMethodCallException if not supported
     * @api
     */
    public function select(
        $col = '',
        /*# string */ $alias = ''
    )/*# : SelectStatementInterface */;
}
