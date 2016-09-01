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
 * FromClauseInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface FromClauseInterface extends ClauseInterface
{
    /**
     * FROM clause, APPEND to from table[s] if any
     *
     * ```php
     * // FROM `users`, `accounts`
     * select()->from('users')->from('accounts')
     *
     * // FROM `users` `u`, `accounts` AS `a`
     * select()->from('users', 'u')->from('accounts', 'a')
     *
     * // FROM `users`, `accounts`
     * select()->from(['users', 'accounts'])
     *
     * // FROM `users`, `accounts` AS `a`
     * select()->from(['users', 'accounts' => 'a'])
     *
     * // FROM (SELECT `id` FROM `users` WHERE `id` < 10) AS `sub`
     * select()->from($users->select('id')->where('id < 10'), 'sub');
     * ```
     *
     * @param  string|array|SelectStatementInterface $table table[s]
     * @param  string $tableAlias alias to be used later in the query
     * @return $this
     * @access public
     * @api
     */
    public function from(
        $table,
        /*# string */ $tableAlias = ''
    );

    /**
     * Simliar to from(), but REPLACE current table[s] !
     *
     * ```php
     * // FROM `accounts` (NO 'users')
     * select()->from('users')->table('accounts')
     *
     * // FROM `users`, `accounts` (HAS users)
     * select()->table('users')->from('accounts')
     *
     * // FROM `users`, `accounts`
     * select()->table(['users', 'accounts'])
     * ```
     *
     * @param  string|array|SelectStatementInterface $table table[s]
     * @param  string $tableAlias alias to be used later in the query
     * @return $this
     * @access public
     * @api
     */
    public function table(
        $table,
        /*# string */ $tableAlias = ''
    );
}
