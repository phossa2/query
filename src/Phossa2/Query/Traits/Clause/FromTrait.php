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
                $clause[] = $table;
            } else {
                $clause[(string) $alias] = $table;
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
     * @return array
     * @access protected
     */
    protected function buildFrom(array $settings)/*# : string */
    {
        $result = [];
        $clause = &$this->getClause('FROM');
        foreach ($clause as $as => $tbl) {
            $alias = $this->quoteAlias($as);
            $table = $this->quoteItem($tbl);
            $result[] = $table . $alias;
        }
        return $this->joinClause('FROM', ',', $result, $settings);
    }

    abstract protected function quoteAlias($alias)/*# : string */;
    abstract protected function quoteItem($item, /*# bool */ $rawMode = false)/*# : string */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
}
