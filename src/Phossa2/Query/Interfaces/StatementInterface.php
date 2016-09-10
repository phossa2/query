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
 * StatementInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @see     SettingsInterface
 * @see     BuilderAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface StatementInterface extends DialectAwareInterface, SettingsInterface, BuilderAwareInterface
{
    /**
     * Return the statement string
     *
     * @param  array $settings extra settings if any
     * @return string
     * @access public
     * @api
     */
    public function getStatement(array $settings = [])/*# : string */;

    /**
     * Get the statement with default settings & dialect
     *
     * @return string
     * @access public
     * @api
     */
    public function __toString()/*# : string */;
}
