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

use Phossa2\Query\Interfaces\Clause\ExtraClauseInterface;

/**
 * StatementInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsAwareInterface
 * @see     BuilderAwareInterface
 * @see     OutputInterface
 * @see     ExtraClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface StatementInterface extends SettingsAwareInterface, BuilderAwareInterface, OutputInterface, ExtraClauseInterface
{
    /**
     * Return statement with ':name' not quoted
     *
     * @param  array $settings
     * @return string
     * @access public
     * @api
     */
    public function getNamedStatement(array $settings = [])/*# : string */;

    /**
     * Return the sql string (with parameter replaced)
     *
     * @param  array $settings extra settings if any
     * @return string
     * @access public
     * @api
     */
    public function getSql(array $settings = [])/*# : string */;

    /**
     * Return binding values
     *
     * @return array
     * @access public
     * @api
     */
    public function getBindings()/*# : array */;
}
