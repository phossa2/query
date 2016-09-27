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
use Phossa2\Query\Interfaces\OutputInterface;

/**
 * Template
 *
 * Clause template
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Raw
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Template extends Raw
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
     * Constructor
     *
     * @param  string|OutputInterface $template
     * @param  string|string[] $col column[s]
     * @access public
     */
    public function __construct($template, $col)
    {
        $this->template = (string) $template;
        $this->col = $col;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(array $settings = [])/*# : string */
    {
        if (!empty($settings)) {
            $quoted = [];
            foreach ((array) $this->col as $c) {
                $quoted[] = $this->quote($c, $settings);
            }
        } else {
            $quoted = (array) $this->col;
        }
        return vsprintf($this->template, $quoted);
    }
}
