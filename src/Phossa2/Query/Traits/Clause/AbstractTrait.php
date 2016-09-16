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

/**
 * AbstractTrait
 *
 * Collection of abstract methods for other traits
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait AbstractTrait
{
    abstract public function getBuilder()/*# : BuilderInterface */;
    abstract public function setSettings(array $settings);
    abstract protected function getType()/*# : string */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function processValue($value, array $settings, /*# bool */ $between = false)/*# : string */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
    abstract protected function quote(/*# string */ $str, array $settings)/*# : string */;
}
