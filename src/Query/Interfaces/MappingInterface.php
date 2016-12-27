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

namespace Phossa2\Query\Interfaces;

/**
 * MappingInterface
 *
 * Map table name or column name to another string.
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.1.0
 * @since   2.1.0 added
 */
interface MappingInterface
{
    /**
     * Set mapping prefix or callable or set to NULL
     *
     * @param  string $id map id
     * @param  string|callable|null $tableMap
     * @param  string|callable|null $columnMap
     * @return $this
     * @access public
     * @api
     */
    public function setMapping(/*# string */ $id, $tableMap, $columnMap);
}
