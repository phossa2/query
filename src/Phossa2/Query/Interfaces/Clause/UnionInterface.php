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
use Phossa2\Query\Interfaces\BuilderInterface;

/**
 * UnionInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface UnionInterface extends ClauseInterface
{
    const UNION_NOT = 0;
    const UNION_YES = 1;
    const UNION_ALL = 2;

    /**
     * Union with another SELECT
     *
     * @return BuilderInterface
     * @access public
     * @api
     */
    public function union()/*# : BuilderInterace */;

    /**
     * Union all with another SELECT
     *
     * @return BuilderInterface
     * @access public
     * @api
     */
    public function unionAll()/*# : BuilderInterace */;
}
