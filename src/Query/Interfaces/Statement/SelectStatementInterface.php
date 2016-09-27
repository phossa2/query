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
use Phossa2\Query\Interfaces\Clause\ColInterface;
use Phossa2\Query\Interfaces\Clause\TableInterface;
use Phossa2\Query\Interfaces\Clause\WhereInterface;
use Phossa2\Query\Interfaces\Clause\LimitInterface;
use Phossa2\Query\Interfaces\Clause\HavingInterface;
use Phossa2\Query\Interfaces\Clause\GroupInterface;
use Phossa2\Query\Interfaces\Clause\OrderInterface;

/**
 * SelectStatementInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementInterface
 * @see     ColInterface
 * @see     TableInterface
 * @see     WhereInterface
 * @see     GroupInterface
 * @see     HavingInterface
 * @see     OrderInterface
 * @see     LimitInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface SelectStatementInterface extends StatementInterface, ColInterface, TableInterface, WhereInterface, GroupInterface, HavingInterface, OrderInterface, LimitInterface
{
}
