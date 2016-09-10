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

use Phossa2\Query\Interfaces\RawInterface;
use Phossa2\Query\Interfaces\ClauseInterface;
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
    /**
     * storage for clauses
     *
     * @var    array
     * @access protected
     */
    protected $clause = [];

    /**
     * Is $str a raw string ?
     *
     * @param  mixed $str
     * @param  bool $rawMode
     * @access protected
     */
    protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */
    {
        if ($rawMode) {
            return true;
        } elseif (is_string($str)) {
            return (bool) preg_match('/[^0-9a-zA-Z\$_.]/', $str);
        } elseif (is_object($str) && $str instanceof RawInterface) {
            return true;
        }
        return false;
    }

    /**
     * Quote an alias if not an int
     *
     * @param  int|string $alias
     * @return string
     * @access protected
     */
    protected function quoteAlias($alias)/*# : string */
    {
        return is_int($alias) ? '' : (' AS ' . $this->quoteSpace($alias));
    }

    /**
     * Quote an item with spaces allowed in between
     *
     * @param  string|StatementInterface $item
     * @param  bool $rawMode
     * @access protected
     */
    protected function quoteItem(
        $item, /*# bool */ $rawMode = false
    )/*# : string */ {
        if (is_object($item) && $item instanceof StatementInterface) {
            // @TODO quoteItem check settings
            return '(' . $item->getStatement([], false) . ')';
        } else {
            return $rawMode ? (string) $item : $this->quote($item);
        }
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
     * Convert a template 'COUNT(%s)' to 'COUNT(`score`)'
     *
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @return string
     * @access protected
     */
    protected function clauseTpl(/*# string */ $template, $col)/*# : string */
    {
        $quoted = [];
        foreach ((array) $col as $c) {
            $quoted[] = $this->quote($c);
        }
        return vsprintf($template, $quoted);
    }

    protected function quote(/*# string */ $str)/*# : string */
    {
        // @TODO quote()
        return '"' . $str . '"';
    }

    protected function quoteSpace(/*# string */ $str)/*# : string */
    {
        // @TODO quoteSpace
        return $this->quote($str);
    }

    /**
     * Process value
     *
     * @param  mixed $value
     * @return string
     * @access protected
     */
    protected function processValue($value)/*# : string */
    {
        // @TODO processValue
        return (string) $value;
    }

    /**
     * Join each clause
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
            $join = $settings['seperator'] . $settings['indent'];
            $pref = empty($prefix) ? '' : ($prefix . $join);
            return $settings['seperator'] . $pref . join($seperator . $join, $clause);
        }
    }
}
