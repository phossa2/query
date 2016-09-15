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

use Phossa2\Query\Interfaces\Statement\InsertStatementInterface;

/**
 * BuilderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @see     SettingsAwareInterface
 * @see     SelectInterface
 * @see     FromInterface
 * @see     ParameterAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsAwareInterface, SelectInterface, FromInterface, ParameterAwareInterface
{
    /**
     * Create a complex expression
     *
     * ```php
     * $users = new Builder('Users', new Mysql());
     *
     * // SELECT
     *        *
     * // FROM
     *        Users
     * // WHERE
     * //     (age < 18 OR gender = 'female') OR
     * //     (age > 60 OR (age > 55 AND gender = 'female'))
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
     * Raw string with variable placeholders
     *
     * ```php
     * // with variable placeholders
     * $builder->select()->col($builder->raw('RANGE(?, ?)', 1, 10));
     * ```
     *
     * @param  string $string
     * @return OutputInterface
     * @access public
     * @api
     */
    public function raw(/*# string */ $string)/*# : OutputInterface */;

    /**
     * Build an INSERT statement
     *
     * @param  array $values colname and value pairs
     * @return InsertStatementInterface
     * @access public
     * @api
     */
    public function insert(array $values = [])/*# : InsertStatementInterface */;
}
