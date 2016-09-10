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
     * @api
     */
    public function setDialect(DialectInterface $dialect = null);

    /**
     * Has dialect set ?
     *
     * @return bool
     * @access public
     * @api
     */
    public function hasDialect()/*# : bool */;

    /**
     * Get the dialect, if not set get Mysql dialect
     *
     * @return DialectInterface
     * @access public
     * @api
     */
    public function getDialect()/*# : DialectInterface */;
}
