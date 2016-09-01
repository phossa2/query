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
 * DialectAwareInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface DialectAwareInterface
{
    /**
     * Set the dialect
     *
     * @param  DialectInterface $dialect
     * @return $this
     * @access public
     */
    public function setDialect(DialectInterface $dialect);

    /**
     * Get the dialect
     *
     * @return DialectInterface
     * @access public
     */
    public function getDialect()/*# : DialectInterface */;
}
