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

use Phossa2\Query\Message\Message;
use Phossa2\Shared\Base\ObjectAbstract;
use Phossa2\Query\Interfaces\DialectInterface;
use Phossa2\Query\Exception\BadMethodCallException;

/**
 * Common
 *
 * Common dialect
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     DialectInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Common extends ObjectAbstract implements DialectInterface
{
    public function __call(/*# string */ $method, array $params)
    {
        $class = $this->getClassName() . '\\' . ucfirst(strtolower($method));
        if (class_exists($class)) {
            return new $class($params[0]);
        }

        throw new BadMethodCallException(
            Message::get(Message::MSG_METHOD_NOTFOUND, $method, $this),
            Message::MSG_METHOD_NOTFOUND
        );
    }

    /**
     * {@inheritDoc}
     */
    public function dialectSettings()/*# : array */
    {
        return [
            'quotePrefix' => '"',
            'quoteSuffix' => '"'
        ];
    }
}
