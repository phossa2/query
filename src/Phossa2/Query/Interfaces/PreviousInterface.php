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
 * PreviousInterface
 *
 * Dealing with UNION/UNION ALL
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface PreviousInterface
{
    /**
     * Set previous statement
     *
     * @param  StatementInterface $previous
     * @return $this
     * @access public
     */
    public function setPrevious(StatementInterface $previous = null);

    /**
     * Has previous statement
     *
     * @return bool
     * @access public
     */
    public function hasPrevious()/*# : bool */;

    /**
     * Get previous statement
     *
     * @return StatementInterface
     * @access public
     */
    public function getPrevious()/*# : StatementInterface */;
}
