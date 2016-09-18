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

use Phossa2\Query\Interfaces\OutputInterface;
use Phossa2\Query\Interfaces\ClauseInterface;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\StatementInterface;

/**
 * ClauseTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait ClauseTrait
{
    use QuoteTrait;

    /**
     * storage for clauses
     *
     * @var    array
     * @access protected
     */
    protected $clause = [];

    /**
     * Is $str a raw sql string ?
     *
     * @param  mixed $str
     * @param  bool $rawMode
     * @access protected
     */
    protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */
    {
        if ($rawMode) {
            return true;
        }

        if (is_string($str)) {
            return (bool) preg_match('/[^0-9a-zA-Z\$_.]/', $str);
        }

        return is_object($str);
    }

    /**
     * Quote an alias if not an int
     *
     * @param  int|string $alias
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function quoteAlias($alias, array $settings)/*# : string */
    {
        if (is_int($alias)) {
            return '';
        } else {
            $prefix = $settings['quotePrefix'];
            $suffix = $settings['quoteSuffix'];
            return ' AS ' . $this->quoteSpace($alias, $prefix, $suffix);
        }
    }

    /**
     * Quote an item if it is a field/column
     *
     * @param  string|StatementInterface $item
     * @param  array $settings
     * @param  bool $rawMode
     * @access protected
     */
    protected function quoteItem(
        $item,
        array $settings,
        /*# bool */ $rawMode = false
    )/*# : string */ {
        // is an object
        if (is_object($item)) {
            return $this->quoteObject($item, $settings);
        }

        // is a string, quote with prefix and suffix
        return $rawMode ? $item : $this->quote($item, $settings);
    }

    /**
     * Quote object
     *
     * @param  object $object
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function quoteObject($object, $settings)/*# : string */
    {
        if ($object instanceof StatementInterface) {
            $settings = $this->flatSettings($settings);
            return '(' . ltrim($object->getStatement($settings)) . ')';
        } elseif ($object instanceof OutputInterface) {
            return $object->getStatement($settings);
        }
        return (string) $object;
    }

    /**
     * Return specific clause part
     *
     * @param  string $clauseName
     * @param  array
     * @access protected
     */
    protected function &getClause(/*# string */ $clauseName)/*# : array */
    {
        if (empty($clauseName)) {
            return $this->clause;
        } else {
            if (!isset($this->clause[$clauseName])) {
                $this->clause[$clauseName] = [];
            }
            return $this->clause[$clauseName];
        }
    }

    /**
     * Quote string even with space inside
     *
     * @param  string $str
     * @param  string $prefix
     * @param  string $suffix
     * @return string
     * @access protected
     */
    protected function quoteSpace(
        /*# string */ $str,
        /*# string */ $prefix,
        /*# string */ $suffix
    )/*# : string */ {
        return sprintf('%s%s%s', $prefix, $str, $suffix);
    }

    /**
     * Process value part in the clause
     *
     * @param  mixed $value
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function processValue(
        $value,
        array $settings,
        /*# bool */ $between = false
    )/*# : string */ {
        if (is_object($value)) {
            return $this->quoteObject($value, $settings);
        } elseif (is_array($value)) {
            return $this->processArrayValue($value, $settings, $between);
        } else {
            return $this->processScalarValue($value);
        }
    }

    /**
     * Process value array
     *
     * @param  array $value
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function processArrayValue(
        array $value,
        array $settings,
        /*# bool */ $between = false
    )/*# : string */ {
        if ($between) {
            $v1 = $this->processValue($value[0], $settings);
            $v2 = $this->processValue($value[1], $settings);
            return $v1 . ' AND ' . $v2;
        } else {
            $result = [];
            foreach ($value as $val) {
                $result[] = $this->processValue($val, $settings);
            }
            return '(' . join(', ', $result) . ')';
        }
    }

    /**
     * Process scalar value
     *
     * @param  mixed $value
     * @return string
     * @access protected
     */
    protected function processScalarValue($value)/*# : string */
    {
        if (ClauseInterface::NO_VALUE == $value) {
            return '?';
        } elseif (is_null($value) || is_bool($value)) {
            return strtoupper(var_export($value, true));
        } else {
            return $this->getBuilder()->getParameter()->getPlaceholder($value);
        }
    }

    /**
     * Join a clause with prefix and its parts
     *
     * @param  string $prefix
     * @param  string $seperator
     * @param  array $clause
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */ {
        if (empty($clause)) {
            return '';
        } else {
            $sepr = $settings['seperator'];
            $join = $settings['join'];
            $pref = empty($prefix) ? $join : ($sepr . $prefix . $join);
            return $pref . join($seperator . $join, $clause);
        }
    }

    /**
     * Build a generic clause
     *
     * @param  string $clauseName
     * @param  string $clausePrefix
     * @param  array $settings
     * @param  array $clauseParts
     * @return string
     * @access protected
     */
    protected function buildClause(
        /*# string */ $clauseName,
        /*# string */ $clausePrefix,
        array $settings,
        array $clauseParts = []
    )/*# string */ {
        $clause = &$this->getClause($clauseName);
        foreach ($clause as $alias => $field) {
            $part =
                $this->quoteItem($field[0], $settings, $field[1]) .
                $this->quoteAlias($alias, $settings) .
                (isset($field[2]) ? (' ' . $field[2]) : '');
            $clauseParts[] = $part;
        }
        return $this->joinClause($clausePrefix, ',', $clauseParts, $settings);
    }

    /**
     * Reset settings to print flat
     *
     * @param  array $settings
     * @return array
     * @access protected
     */
    protected function flatSettings(array $settings)/*# : array */
    {
        return array_replace(
            $settings,
            ['seperator' => ' ', 'indent' => '']
        );
    }

    /**
     * Dealing with positioned parameters
     *
     * e.g. havingRaw('id > ?', [10]) turns into  havingRaw('id > 10')
     *
     * @param  string $rawString
     * @param  array $values
     * @access protected
     */
    protected function positionedParam(
        /*# string */ $rawString,
        array $values
    )/*# : string */ {
        return $this->getBuilder()->raw($rawString, $values);
    }

    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    abstract public function getBuilder()/*# : BuilderInterface */;
}
