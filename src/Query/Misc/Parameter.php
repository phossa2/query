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

namespace Phossa2\Query\Misc;

/**
 * Parameter
 *
 * Dealing with positioned or named parameters
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Parameter
{
    /**
     * parameter pool
     *
     * @var    array
     * @access protected
     */
    protected $parameters;

    /**
     * The escape callable
     *
     * @var    callable
     * @access protected
     */
    protected $escape;

    /**
     * Returns a replacement placeholder for a $value
     *
     * @param  mixed $value
     * @return string
     * @access public
     */
    public function getPlaceholder($value)/*# : string */
    {
        // unique key with a pattern
        $key = uniqid('__PHQUERY_') . '__';
        $this->parameters[$key] = $value;
        return $key;
    }

    /**
     * Replace placeholders in the SQL with '?' or real value
     *
     * @param  string $sql
     * @param  array &$bindings
     * @param  array $settings
     * @return string
     * @access public
     */
    public function bindValues(
        /*# string */ $sql,
        array &$bindings,
        array $settings
    )/*# : string */ {
        // make sure escape function ok
        $this->setEscapeCallable($settings['escapeFunction']);

        // replace each placeholder with corresponding ?/:name/value
        return preg_replace_callback(
            '/\b__PHQUERY_[^_]++__\b/',
            function ($m) use (&$bindings, $settings) {
                return $this->replacePlaceholders($m[0], $bindings, $settings);
            },
            $sql
        );
    }

    /**
     * Replace '?' in the string with placeholders for value.
     *
     * e.q.  replace 'RANGE(?, ?)' with values [1, 10] etc.
     *
     * @param  string $string
     * @param  array $values
     * @access public
     */
    public function replaceQuestionMark(
        /*# string */ $string,
        array $values
    )/*# : string */ {
        $pat = $rep = [];
        foreach ($values as $val) {
            $pat[] = '/\?/'; // question mark
            $rep[] = $this->getPlaceholder($val); // placeholder
        }
        return preg_replace($pat, $rep, $string, 1);
    }

    /**
     * Replace each placeholder with '?', ':name' or value
     *
     * @param  string $key
     * @param  array &$bindings
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function replacePlaceholders(
        /*# string */ $key,
        array &$bindings,
        array $settings
    )/*# : string */ {
        $escape = $this->escape;

        $value = $this->parameters[$key];
        if ($settings['positionedParam']) {
            $bindings[] = $value;
            return '?';
        } elseif ($settings['namedParam'] && $this->isNamedParam($value)) {
            return $value;
        } else {
            return $escape($value);
        }
    }

    /**
     * Is it a named parameter ?
     *
     * @param  mixed $value
     * @return bool
     * @access protected
     */
    protected function isNamedParam($value)/*# : bool */
    {
        return is_string($value) && preg_match('/^:[a-zA-Z]\w*$/', $value);
    }

    /**
     * Set escape/quote method/function
     *
     * @param  null|callable $escapeFunction defult escape function
     * @return $this
     * @access protected
     */
    protected function setEscapeCallable($escapeFunction)/*# : callable */
    {
        if (!is_callable($escapeFunction)) {
            $this->escape = function ($v) {
                if (is_numeric($v) && !is_string($v)) {
                    return $v;
                } else {
                    return "'" . str_replace("'", "\\'", (string) $v) . "'";
                }
            };
        } else {
            $this->escape = $escapeFunction;
        }
        return $this;
    }
}
