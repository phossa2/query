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

use Phossa2\Query\Interfaces\ClauseInterface;
use Phossa2\Query\Interfaces\Clause\SetInterface;

/**
 * SetTrait
 *
 * Implementation of SetInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SetInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait SetTrait
{
    use AbstractTrait;

    /**
     * data storage
     *
     * @var    array
     * @access protected
     */
    protected $set_data = [];

    /**
     * data row number
     *
     * @var    int
     * @access protected
     */
    protected $set_row = 0;

    /**
     * storage for col names
     *
     * @var    array
     * @access protected
     */
    protected $set_col = [];

    /**
     * {@inheritDoc}
     */
    public function set($col, $value = ClauseInterface::NO_VALUE)
    {
        if (is_array($col)) { // array provided
            return $this->setWithArrayData($col);
        }
        if (!isset($this->set_col[$col])) { // save col names
            $this->set_col[$col] = true;
        }
        if (ClauseInterface::NO_VALUE === $value) { // auto positionedParam
            $this->setSettings(['positionedParam' => true]);
        }

        $this->set_data[$this->set_row][$col] = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRaw(/*# string */ $col, $value = ClauseInterface::NO_VALUE)
    {
        if (ClauseInterface::NO_VALUE !== $value) {
            if (func_num_args() > 2) {
                $value = $this->getBuilder()
                    ->raw($value, (array) func_get_arg(2));
            } else {
                $value = $this->getBuilder()->raw($value);
            }
        }
        return $this->set((string) $col, $value);
    }

    /**
     * Batch SET
     *
     * @param  array $data
     * @return $this
     * @access protected
     */
    protected function setWithArrayData(array $data)
    {
        if (isset($data[0])) { // multiple rows
            foreach ($data as $row) {
                $this->set($row);
            }
        } else { // multiple values
            foreach ($data as $col => $val) {
                $this->set($col, $val);
            }
            $this->set_row++;
        }
        return $this;
    }

    /**
     * Build SET
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildSet(
        /*# string */ $prefix,
        array $settings
    )/*# : array */ {
        if ('UPDATE' === $this->getType()) {
            return $this->buildUpdateSet($prefix, $settings);
        } else {
            return $this->buildInsertSet($prefix, $settings);
        }
    }

    /**
     * Build SET for INSERT
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildInsertSet(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        if (empty($this->set_data)) {
            return '';
        }

        $cols = [];
        foreach (array_keys($this->set_col) as $col) {
            $cols[] = $this->quote($col, $settings);
        }
        return $settings['seperator'] . '(' . join(', ', $cols) . ')';
    }

    /**
     * Build SET ... = ..., ... = ...
     *
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildUpdateSet(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $result = [];
        foreach ($this->set_data[0] as $col => $val) {
            $result[] = $this->quote($col, $settings) . ' = ' .
                $this->processValue($val, $settings);
        }
        return $this->joinClause($prefix, ',', $result, $settings);
    }

    /**
     * Build VALUES ( ... )
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildValues(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $rows = [];
        $cols = array_keys($this->set_col);
        foreach ($this->set_data as $num => $row) {
            $values = [];
            foreach ($cols as $col) {
                $values[] = isset($row[$col]) ?
                    $this->processValue($row[$col], $settings) :
                    $this->nullOrDefault($settings);
            }
            $rows[] = '(' . join(', ', $values) . ')';
        }
        return $this->joinClause($prefix, ',', $rows, $settings);
    }

    /**
     * Get NULL or DEFAULT for values base on the settings
     *
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function nullOrDefault(array $settings)/*# : string */
    {
        return $settings['useNullAsDefault'] ? 'NULL' : 'DEFAULT';
    }
}