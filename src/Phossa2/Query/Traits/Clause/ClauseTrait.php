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
use Phossa2\Query\Interfaces\TemplateInterface;
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

        return is_object($str) && $str instanceof RawInterface;
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
        $prefix = $settings['quotePrefix'];
        $suffix = $settings['quoteSuffix'];
        return is_int($alias) ?
            '' : (' AS ' . $this->quoteSpace($alias, $prefix, $suffix));
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
        if (is_object($item)) {
            if ($item instanceof StatementInterface) {
                $settings = array_merge(
                    $settings,
                    ['seperator' => ' ', 'indent' => '']
                );
                return '(' . $item->getStatement($settings) . ')';
            }
            if ($item instanceof TemplateInterface) {
                return $item->getOutput($settings);
            }
        }
        return $rawMode ? (string) $item :
            $this->quote($item, $settings['quotePrefix'], $settings['quoteSuffix']);
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
     * Quote string even space found
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
