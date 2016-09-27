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
 * QuoteTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait QuoteTrait
{
    /**
     * Quote string base on settings only if '[a-zA-Z_.\$]' found
     *
     * - username to `username`
     * - u.username to `u`.`username`
     *
     * @param  string $str
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function quote(
        /*# string */ $str,
        array $settings
    )/*# : string */ {
        // pattern
        $pattern = '/^[a-zA-Z\$][0-9a-zA-Z_.\$]*+$/';
        $prefix = $settings['quotePrefix'];
        $suffix = $settings['quoteSuffix'];

        if (preg_match($pattern, $str)) {
            return preg_replace_callback(
                '/\b([a-zA-Z\$][0-9a-zA-Z_\$]*+)\b/',
                function ($m) use ($prefix, $suffix) {
                    return sprintf('%s%s%s', $prefix, $m[1], $suffix);
                },
                $str
            );
        }
        return $str;
    }
}
