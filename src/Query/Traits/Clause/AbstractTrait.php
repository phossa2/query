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
    // in BuilderAwareTrait
    abstract public function getBuilder()/*# : BuilderInterface */;

    // in SettingsAwareTrait
    abstract public function setSettings(array $settings);

    // in StatementAbstract
    abstract protected function getType()/*# : string */;
    abstract protected function combineSettings(array $settings)/*# : array */;
    abstract protected function buildSql(array $settings)/*# : string */;
    abstract protected function bindValues(/*# string */ $sql, array $settings)/*# : string */;

    // in QuoteTrait
    abstract protected function quote(/*# string */ $str, array $settings)/*# : string */;

    // in PreviousTrait
    abstract protected function hasPrevious()/*# : bool */;
    abstract protected function getPrevious()/*# : StatementInterface */;

    // in ClauseTrait
    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function processValue($value, array $settings, /*# bool */ $between = false)/*# : string */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
    abstract protected function buildClause(
        /*# string */ $clauseName,
        /*# string */ $clausePrefix,
        array $settings,
        array $clauseParts = []
    )/*# string */;
    abstract protected function flatSettings(array $settings)/*# : array */;
    abstract protected function quoteItem(
        $item,
        array $settings,
        /*# bool */ $rawMode = false
    )/*# : string */;
    abstract protected function quoteAlias($alias, array $settings)/*# : string */;
    abstract protected function positionedParam(/*# string */ $rawString, array $values)/*# : string */;
}
