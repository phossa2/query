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

use Phossa2\Query\Interfaces\Statement\UnionStatementInterface;
use Phossa2\Query\Interfaces\Statement\InsertStatementInterface;
use Phossa2\Query\Interfaces\Statement\UpdateStatementInterface;
use Phossa2\Query\Interfaces\Statement\DeleteStatementInterface;

/**
 * BuilderInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @see     SettingsAwareInterface
 * @see     SelectInterface
 * @see     TableInterface
 * @see     ParameterAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsAwareInterface, SelectInterface, TableInterface, ParameterAwareInterface
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
     * Raw string with placeholders
     *
     * ```php
     * // with placeholders
     * $builder->select()->col($builder->raw('RANGE(?, ?)', [1, 10]));
     * ```
     *
     * @param  string $string
     * @param  array $values
     * @return OutputInterface
     * @access public
     * @api
     */
    public function raw(
        /*# string */ $string,
        array $values = []
    )/*# : OutputInterface */;

    /**
     * Build an INSERT statement
     *
     * @param  array $values colname and value pairs
     * @return InsertStatementInterface
     * @access public
     * @api
     */
    public function insert(array $values = [])/*# : InsertStatementInterface */;

    /**
     * Build an UPDATE statement
     *
     * @param  array $values colname and value pairs
     * @return UpdateStatementInterface
     * @access public
     * @api
     */
    public function update(array $values = [])/*# : UpdateStatementInterface */;

    /**
     * Build a REPLACE statement
     *
     * @param  array $values colname and value pairs
     * @return InsertStatementInterface
     * @access public
     * @api
     */
    public function replace(array $values = [])/*# : InsertStatementInterface */;

    /**
     * Build a DELETE statement
     *
     * ```php
     * // DELETE `u`, `a` FROM `Users` AS `u` INNER JOIN `Accounts` AS `a` ON ...
     * $users->delete('u', 'a')->table('Users', 'u')
     *     ->join(['Accounts' => 'a'], 'id')->where()
     * ```
     *
     * @return DeleteStatementInterface
     * @access public
     * @api
     */
    public function delete()/*# : DeleteStatementInterface */;

    /**
     * Builder level union, takes variable parameters.
     *
     * ```php
     * // (SELECT * FROM `Users`) UNION (SELECT * FROM `oldUsers`) ORDER BY ...
     * $builder->union(
     *    $builder->select()->table('Users'),
     *    $builder->select()->table('oldUsers')
     * )->order('user_id')->limit(10);
     * ```
     *
     * @return UnionStatementInterface
     * @access public
     * @api
     */
    public function union()/*# : UnionStatementInterface */;
}
