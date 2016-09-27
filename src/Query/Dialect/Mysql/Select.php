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

namespace Phossa2\Query\Dialect\Mysql;

use Phossa2\Query\Traits\Clause\PartitionTrait;
use Phossa2\Query\Interfaces\Clause\PartitionInterface;
use Phossa2\Query\Dialect\Common\Select as CommonSelect;

/**
 * Mysql Select
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     PartitionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Select extends CommonSelect implements PartitionInterface
{
    use PartitionTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'DISTINCT' => '',
            'COL' => '',
            'TABLE' => 'FROM',
            'JOIN' => '',
            'PARTITION' => 'PARTITION', // added partition here
            'WHERE' => 'WHERE',
            'GROUP' => 'GROUP BY',
            'HAVING' => 'HAVING',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
            'UNION' => '',
        ];
    }
}
