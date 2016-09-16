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
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * JoinInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface JoinInterface extends ClauseInterface
{
    /**
     * INNER JOIN
     *
     * ```php
     * // INNER JOIN `Constacts` ON `Users`.`id` = `Contacts`.`id`
     * $uesrs->join('Contacts', 'id')
     *
     * // INNER JOIN `Contacts` AS `c` ON `Users`.`user_id` = `Contacts`.`uid`
     * $users->join(['Contacts', 'c'], ['user_id', 'uid']);
     * ```
     *
     * @param  string|string[]|SelectStatementInterface $secondTable
     * @param  string|string[]|ExpressionInterface $onClause
     * @param  string $firstTable default is the first one in SELECT
     * @return $this
     * @access public
     * @api
     */
    public function join($secondTable, $onClause = '', $firstTable = '');

    /**
     * LEFT JOIN
     *
     * ```php
     * // LEFT JOIN `Constacts` ON `Users`.`id` = `Contacts`.`id`
     * $uesrs->leftJoin('Contacts', 'id')
     *
     * // LEFT JOIN `Contacts` AS `c` ON `Users`.`user_id` = `Contacts`.`uid`
     * $users->leftJoin(['Contacts', 'c'], ['user_id', 'uid']);
     * ```
     *
     * @param  string|string[]|SelectStatementInterface $secondTable
     * @param  string|string[]|ExpressionInterface $onClause
     * @param  string $firstTable default is the first one in SELECT
     * @return $this
     * @access public
     * @api
     */
    public function leftJoin($secondTable, $onClause = '', $firstTable = '');

    /**
     * Raw join
     *
     * Support third param as positioned param
     *
     * ```php
     * // INNER JOIN Constacts c ON Users.id = c.id
     * $uesrs->joinRaw('INNER JOIN', 'Constacts c ON Users.id = c.id')
     *
     * // INNER JOIN Constracts c ON Users.id = 10
     * $users->joinRaw('INNER JOIN', 'Constracts c ON Users.id = ?', [10])
     * ```
     *
     * @param  string $joinType 'INNER JOIN' etc.
     * @param  string $rawString
     * @return $this
     * @access public
     * @api
     */
    public function joinRaw(/*# string */ $joinType, /*# string */ $rawString);
}
