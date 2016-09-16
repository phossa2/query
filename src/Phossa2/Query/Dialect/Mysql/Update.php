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
use Phossa2\Query\Traits\Clause\OrderByTrait;
use Phossa2\Query\Interfaces\Clause\LimitInterface;
use Phossa2\Query\Interfaces\Clause\OrderByInterface;
use Phossa2\Query\Dialect\Common\Update as CommonUpdate;

/**
 * Mysql Update
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     CommonUpdate
 * @see     OrderByInterface
 * @see     LimitInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Update extends CommonUpdate implements OrderByInterface, LimitInterface
{
    use OrderByTrait, LimitTrait;

    /**
     * {@inheritDoc}
     */
    protected $configs = [
        'FROM' => '',
        'SET' => 'SET',
        'WHERE' => 'WHERE',
        'ORDERBY' => 'ORDER BY',
        'LIMIT' => 'LIMIT',
    ];
}
