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
 * TableInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface TableInterface
{
    /**
     * FROM clause, APPEND to existing table lists
     *
     * ```php
     * // FROM `users`, `accounts`
     * from('users')->from('accounts')
     *
     * // FROM `users` `u`, `accounts` AS `a`
     * ->from('users', 'u')->from('accounts', 'a')
     *
     * // FROM `users`, `accounts`
     * ->from(['users', 'accounts'])
     *
     * // FROM `users`, `accounts` AS `a`
     * ->from(['users', 'accounts' => 'a'])
     *
     * // FROM (SELECT `id` FROM `users` WHERE `id` < 10) AS `sub`
     * ->from($users->select('id')->where('id < 10'), 'sub');
     * ```
     *
     * @param  string|array|SelectStatementInterface $table table[s]
     * @param  string $alias alias to be used later in the query
     * @return $this
     * @access public
     * @api
     */
    public function from($table, /*# string */ $alias = '');

    /**
     * FROM clause but REPLACE existing table lists !
     *
     * ```php
     * // FROM `accounts`
     * ->from('users')->table('accounts')
     *
     * // FROM `users`, `accounts`
     * ->table('users')->from('accounts')
     *
     * // FROM `users`, `accounts` AS `a`
     * ->table(['users', 'accounts' => 'a'])
     * ```
     *
     * @param  string|array|SelectStatementInterface $table table[s]
     * @param  string $alias alias to be used later in the query
     * @return $this
     * @access public
     * @api
     */
    public function table($table, /*# string */ $alias = '');
}
