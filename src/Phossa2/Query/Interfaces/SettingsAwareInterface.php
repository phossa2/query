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
 * SettingsAwareInterface
 *
 * Used in BuilderInterface and StatementInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface SettingsAwareInterface
{
    /**
     * Set settings
     *
     * @param  array $settings
     * @return $this
     * @access public
     */
    public function setSettings(array $settings);

    /**
     * Get all settings
     *
     * @return array
     * @access public
     */
    public function getSettings()/*# : array */;
}
