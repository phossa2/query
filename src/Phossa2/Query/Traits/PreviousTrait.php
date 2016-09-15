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

namespace Phossa2\Query\Traits;

use Phossa2\Query\Interfaces\StatementInterface;

/**
 * PreviousTrait
 *
 * Dealing with multiple statements, e.g.
 *
 * - SELECT ... UNION ... SELECT
 * - INSERT INTO ... SELECT
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait PreviousTrait
{
    /**
     * Previous statement used in UNION/UNION ALL
     *
     * @var    StatementInterface
     * @access protected
     */
    protected $previous;

    /**
     * Set previous statement
     *
     * @param  StatementInterface $stmt
     * @return $this
     * @access protected
     */
    protected function setPrevious(StatementInterface $stmt)
    {
        $this->previous = $stmt;
        return $this;
    }

    /**
     * Has previous statement ?
     *
     * @return bool
     * @access protected
     */
    protected function hasPrevious()/*# : bool */
    {
        return null !== $this->previous;
    }

    /**
     * Get previous statement
     *
     * @return StatementInterface
     * @access protected
     */
    protected function getPrevious()/*# : StatementInterface */
    {
        return $this->previous;
    }
}
