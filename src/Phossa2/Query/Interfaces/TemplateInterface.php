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
 * TemplateInterface
 *
 * Clause template interface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface TemplateInterface
{
    /**
     * Get output of the template base on settings
     *
     * @param  array $settings
     * @return string
     * @access public
     * @api
     */
    public function getOutput(array $settings)/*# : string */;
}
