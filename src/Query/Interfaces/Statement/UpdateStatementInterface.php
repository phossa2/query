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
use Phossa2\Query\Interfaces\Clause\WhereInterface;
use Phossa2\Query\Interfaces\Clause\UpdateInterface;

/**
 * UpdateStatementInterface
 *
 * ```php
 * // UPDATE `Users` SET `user_name` = 'phossa' WHERE `user_id` = 3
 * $users->update(['user_name' => 'phossa'])->where('user_id', 3);
 *
 * // UPDATE `Users` SET `user_name` = 'phossa', `user_addr` = 'xxx' WHERE `user_id` = 3
 * $users->update()->set('user_name','phossa')
 *     ->set('user_addr', 'xxx')->where('user_id', 3);
 * ```
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementInterface
 * @see     SetInterface
 * @see     TableInterface
 * @see     WhereInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UpdateStatementInterface extends StatementInterface, SetInterface, UpdateInterface, TableInterface, WhereInterface
{
}
