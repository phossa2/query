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

use Phossa2\Query\Interfaces\Clause\TableInterface;

/**
 * TableTrait
 *
 * Implementation of TableInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     TableInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait TableTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function from($table, /*# string */ $alias = '')
    {
        if (is_array($table)) {
            $this->multipleFrom($table);
        } elseif (!empty($table)) {
            $clause = &$this->getClause('TABLE');
            if (empty($alias)) {
                $clause[] = [$table, false];
            } else {
                $clause[(string) $alias] = [$table, false];
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function table($table, /*# string */ $alias = '')
    {
        $clause = &$this->getClause('TABLE');
        $clause = [];
        return $this->from($table, $alias);
    }

    /**
     * from multiple tables
     *
     * @param  array $tables
     * @access protected
     */
    protected function multipleFrom(array $tables)
    {
        foreach ($tables as $key => $val) {
            if (is_int($key)) {
                $this->from($val);
            } else {
                $this->from($key, $val);
            }
        }
    }

    /**
     * Build TABLE
     *
     * @param  string $prefix
     * @param  array $settings
     * @return array
     * @access protected
     */
    protected function buildTable(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('TABLE', $prefix, $settings);
    }
}
