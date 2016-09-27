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

use Phossa2\Query\Traits\Clause\ColTrait;
use Phossa2\Query\Traits\Clause\JoinTrait;
use Phossa2\Query\Traits\Clause\PartitionTrait;
use Phossa2\Query\Interfaces\Clause\ColInterface;
use Phossa2\Query\Interfaces\Clause\JoinInterface;
use Phossa2\Query\Interfaces\Clause\PartitionInterface;
use Phossa2\Query\Dialect\Common\Delete as CommonDelete;

/**
 * Mysql Delete
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     CommonDelete
 * @see     JoinInterface
 * @see     PartitionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Delete extends CommonDelete implements ColInterface, JoinInterface, PartitionInterface
{
    use ColTrait, PartitionTrait, JoinTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'COL' => '',
            'TABLE' => 'FROM',
            'JOIN' => '',
            'PARTITION' => 'PARTITION',
            'WHERE' => 'WHERE',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
        ];
    }
}
