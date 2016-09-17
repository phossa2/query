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

namespace Phossa2\Query\Interfaces\Statement;

use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Interfaces\Clause\SetInterface;
use Phossa2\Query\Interfaces\Clause\TableInterface;
use Phossa2\Query\Interfaces\Clause\SelectInterface;

/**
 * InsertStatementInterface
 *
 * ```php
 * // INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa')
 * $sql = $users->insert()->set('uid', 2)->set('uname', 'phossa')
 *     ->getStatement();
 *
 * // same as above, with array notation
 * $sql = $users->insert()->set(['uid' => 2, 'uname' => 'phossa'])
 *     ->getStatement();
 *
 * // INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa'), (3, 'test')
 * $query = $users->insert()
 *     ->set(['uid' => 2, 'uname' => 'phossa'])
 *     ->set(['uid' => 3, 'uname' => 'test']);
 * ```
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementInterface
 * @see     IntoInterface
 * @see     SetInterface
 * @see     SelectInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface InsertStatementInterface extends StatementInterface, TableInterface, SetInterface, SelectInterface
{
    /**
     * Table name
     *
     * @param  string $table [schema.]table
     * @access public
     * @api
     */
    public function into(/*# string */ $table);
}
