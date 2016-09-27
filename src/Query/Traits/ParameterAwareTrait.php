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

use Phossa2\Query\Misc\Parameter;
use Phossa2\Query\Interfaces\ParameterAwareInterface;

/**
 * ParameterAwareTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ParameterAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait ParameterAwareTrait
{
    /**
     * the Parameter object
     *
     * @var    Parameter
     * @access protected
     */
    protected $parameter;

    /**
     * {@inheritDoc}
     */
    public function getParameter()/*# : Parameter */
    {
        return $this->parameter;
    }

    /**
     * Create Parameter object
     *
     * @return $this
     * @access protected
     */
    protected function initParameter()
    {
        $this->parameter = new Parameter();
        return $this;
    }
}
