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

use Phossa2\Query\Interfaces\OutputInterface;

/**
 * Raw string object
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OutputInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Raw implements OutputInterface
{
    /**
     * raw string
     *
     * @var    string
     * @access protected
     */
    protected $raw_string;

    /**
     * Constructor
     *
     * @param  string $rawSql
     * @access public
     */
    public function __construct(/*# string */ $rawSql)
    {
        $this->raw_string = (string) $rawSql;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(array $settings = [])/*# : string */
    {
        return $this->raw_string;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getStatement();
    }
}
