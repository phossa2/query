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

namespace Phossa2\Query\Dialect;

/**
 * Mysql
 *
 * Mysql dialect
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Common
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Mysql extends Common
{
    /**
     * {@inheritDoc}
     */
    public function dialectSettings()/*# : array */
    {
        return [
            'quotePrefix' => '`',
            'quoteSuffix' => '`'
        ];
    }
}
