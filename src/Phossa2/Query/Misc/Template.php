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

use Phossa2\Query\Traits\Clause\QuoteTrait;
use Phossa2\Query\Interfaces\TemplateInterface;

/**
 * Template
 *
 * Clause template
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     TemplateInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Template implements TemplateInterface
{
    use QuoteTrait;

    /**
     * @var    string
     * @access protected
     */
    protected $template;

    /**
     * @var    string|string[]
     * @access protected
     */
    protected $col;

    /**
     * @param  string $template
     * @param  string|string[] $col column[s]
     * @access public
     */
    public function __construct(/*# string */ $template, $col)
    {
        $this->template = $template;
        $this->col = $col;
    }

    /**
     * Get output of the template base on settings
     *
     * @param  array $settings
     * @return string
     * @access public
     * @api
     */
    public function getOutput(array $settings)/*# : string */
    {
        $quoted = [];
        foreach ((array) $this->col as $c) {
            $quoted[] = $this->quote(
                $c,
                $settings['quotePrefix'],
                $settings['quoteSuffix']
            );
        }
        return vsprintf($this->template, $quoted);
    }
}
