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

use Phossa2\Query\Misc\Parameter;

/**
 * ParameterAwareInterface
 *
 * Aware of positioned or named parameters
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface ParameterAwareInterface
{
    /**
     * Get the Parameter object
     *
     * @return Parameter
     * @access public
     */
    public function getParameter()/*# : Parameter */;
}
