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

use Phossa2\Query\Traits\Clause\LimitTrait;
use Phossa2\Query\Traits\Clause\OrderTrait;
use Phossa2\Query\Interfaces\Clause\LimitInterface;
use Phossa2\Query\Interfaces\Clause\OrderInterface;
use Phossa2\Query\Dialect\Common\Update as CommonUpdate;

/**
 * Mysql Update
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     CommonUpdate
 * @see     OrderInterface
 * @see     LimitInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Update extends CommonUpdate implements OrderInterface, LimitInterface
{
    use OrderTrait, LimitTrait;

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return [
            'TABLE' => '',
            'SET' => 'SET',
            'WHERE' => 'WHERE',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
        ];
    }
}
