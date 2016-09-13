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

use Phossa2\Query\Interfaces\Clause\FromInterface;

/**
 * FromTrait
 *
 * Implementation of FromInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     FromInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait FromTrait
{
    /**
     * {@inheritDoc}
     */
    public function from($table, /*# string */ $alias = '')
    {
        if (is_array($table)) {
            $this->multipleFrom($table);
        } else {
            $clause = &$this->getClause('FROM');
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
        $clause = &$this->getClause('FROM');
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
     * Build FROM
     *
     * @param  string $prefix
     * @param  array $settings
     * @return array
     * @access protected
     */
    protected function buildFrom(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('FROM', 'FROM', $settings);
    }

    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function buildClause(
        /*# string */ $clauseName,
        /*# string */ $clausePrefix,
        array $settings,
        array $clauseParts = []
    )/*# string */;
}
