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
 * SelectInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface SelectInterface
{
    /**
     * Build a SELECT statement.
     *
     * Accepting variable parameters
     *
     * ```php
     * // SELECT DISTINCT
     * ->select()->distinct()
     *
     * // SELECT `user_name`
     * ->select('user_name')
     *
     * // SELECT `user_id`, `user_name`
     * ->select('user_id', 'user_name')
     *
     * @return SelectStatementInterface
     * @access public
     * @api
     */
    public function select()/*# : SelectStatementInterface */;
}
