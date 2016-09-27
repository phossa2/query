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
use Phossa2\Query\Interfaces\Clause\LimitInterface;
use Phossa2\Query\Interfaces\Clause\OrderInterface;

/**
 * UnionStatementInterface
 *
 * For
 * (SELECT ...) UNION (SELECT ...) ORDER BY ... LIMIT ...
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementInterface
 * @see     OrderInterface
 * @see     LimitInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UnionStatementInterface extends StatementInterface, OrderInterface, LimitInterface
{
    /**
     * Add a SELECT to union. takes variable arguments
     *
     * @param  SelectStatementInterface
     * @return $this
     * @access public
     * @api
     */
    public function union(SelectStatementInterface $select);

    /**
     * Add a SELECT to union all. takes variable arguments
     *
     * @param  SelectStatementInterface
     * @return $this
     * @access public
     * @api
     */
    public function unionAll(SelectStatementInterface $select);
}
