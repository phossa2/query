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

use Phossa2\Query\Interfaces\Clause\IntoInterface;

/**
 * IntoTrait
 *
 * Implementation of IntoInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     IntoInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait IntoTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function into(/*# string */ $table)
    {
        $clause = &$this->getClause('INTO');
        $clause[] = [$table, false];
        return $this;
    }

    /**
     * Build INTO
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildInto(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('INTO', $prefix, $settings);
    }
}
