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

use Phossa2\Query\Interfaces\Clause\SelectInterface;
use Phossa2\Query\Interfaces\Statement\InsertStatementInterface;

/**
 * BuilderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @see     SettingsInterface
 * @see     SelectInterface
 * @see     FromInterface
 * @see     ParameterAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsInterface, SelectInterface, FromInterface, ParameterAwareInterface
{
    /**
     * Create an expression
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
     * Pass as raw, do NOT quote
     *
     * ```php
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
     * @param  array $values
     * @return InsertStatementInterface
     * @access public
     */
    public function insert(array $values = [])/*# : InsertStatementInterface */;
}
