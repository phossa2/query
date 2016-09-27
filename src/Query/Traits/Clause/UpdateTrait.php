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

namespace Phossa2\Query\Traits\Clause;

use Phossa2\Query\Interfaces\Clause\UpdateInterface;

/**
 * UpdateTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UpdateInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait UpdateTrait
{
    use SetTrait;

    /**
     * {@inheritDoc}
     */
    public function increment(/*# string */ $col, /*# int */ $step = 1)
    {
        return $this->setTpl($col, '%s + ?', $col, [$step]);
    }

    /**
     * {@inheritDoc}
     */
    public function decrement(/*# string */ $col, /*# int */ $step = 1)
    {
        return $this->setTpl($col, '%s - ?', $col, [$step]);
    }
}
