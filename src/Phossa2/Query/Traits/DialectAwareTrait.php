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

use Phossa2\Query\Interfaces\DialectInterface;
use Phossa2\Query\Interfaces\DialectAwareInterface;

/**
 * DialectAwareTrait
 *
 * Implementation of DialectAwareInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait DialectAwareTrait
{
    /**
     * dialect
     *
     * @var    DialectInterface
     * @access protected
     */
    protected $dialect;

    /**
     * {@inheritDoc}
     */
    public function setDialect(DialectInterface $dialect)
    {
        $this->dialect = $dialect;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDialect()/*# : DialectInterface */
    {
        return $this->dialect;
    }
}
