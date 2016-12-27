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

use Phossa2\Query\Interfaces\MappingInterface;

/**
 * MappingTrait
 *
 * Implementation of MappingInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     MappingInterface
 * @version 2.1.0
 * @since   2.1.0 added
 */
trait MappingTrait
{
    /**
     * table mapping storage
     *
     * @var    array
     * @access protected
     */
    protected $tbl_mapping = [];

    /**
     * column mapping storage
     *
     * @var    array
     * @access protected
     */
    protected $col_mapping = [];

    /**
     * {@inheritDoc}
     */
    public function setMapping(/*# string */ $id, $tableMap, $columnMap)
    {
        if ($tableMap) {
            $this->tbl_mapping[$id] = $tableMap;
        } else {
            unset($this->tbl_mapping[$id]);
        }

        if ($columnMap) {
            $this->col_mapping[$id] = $columnMap;
        } else {
            unset($this->col_mapping[$id]);
        }
        return $this;
    }

    /**
     * Map the given table name to another name
     *
     * @param  string $id
     * @param  string $tableName
     * @return string
     * @access protected
     */
    protected function mapTable(
        /*# string */ $id,
        /*# string */ $tableName
    )/*# : string */ {
        if (isset($this->tbl_mapping[$id])) {
        }
    }

    /**
     * Map the given column name to another name
     *
     * @param  string $columnName
     * @return string
     * @access public
     */
    public function mapColumn(/*# string */ $columnName)/*# : string */
    {

    }

    /**
     * Do the actual mapping
     *
     * @param  string $input
     * @param  string|callable $mapping
     * @return string
     * @access protected
     */
    protected function doMapping(
        /*# string */ $input,
        $mapping
    )/*# : string */ {
        if (is_string($mapping)) {
            return $mapping . $input;
        } elseif (is_callable($mapping)) {
            return (string) $mapping($input);
        } else {
            return $input;
        }
    }
}
