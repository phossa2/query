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

use Phossa2\Query\Interfaces\SettingsInterface;

/**
 * SettingsTrait
 *
 * Implementation of SettingsInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait SettingsTrait
{
    /**
     * settings
     *
     * @var    array
     * @access protected
     */
    protected $settings = [];

    /**
     * {@inheritDoc}
     */
    public function setSettings(array $settings)
    {
        $this->settings = array_replace($this->settings, $settings);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettings()/*# : array */
    {
        return $this->settings;
    }
}
