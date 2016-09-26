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

use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\BuilderAwareInterface;

/**
 * BuilderAwareTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     BuilderAwareInterface
 * @version 2.0.1
 * @since   2.0.0 added
 * @since   2.0.1 changed setBuilder() signature
 */
trait BuilderAwareTrait
{
    /**
     * @var    BuilderInterface
     * @access protected
     */
    protected $builder;

    /**
     * {@inheritDoc}
     *
     * @since  2.0.1 able to set NULL
     */
    public function setBuilder(BuilderInterface $builder = null)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getBuilder()/*# : BuilderInterface */
    {
        return $this->builder;
    }
}
