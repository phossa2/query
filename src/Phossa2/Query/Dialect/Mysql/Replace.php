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
use Phossa2\Query\Dialect\Common\Replace as CommonReplace;

/**
 * Mysql Replace
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     PartitionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Replace extends CommonReplace implements PartitionInterface
{
    use PartitionTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'TABLE' => 'INTO',
            'PARTITION' => 'PARTITION',
            'SET' => '',
            'VALUES' => 'VALUES',
        ];
    }
}
