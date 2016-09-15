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

use Phossa2\Query\Interfaces\Clause\ExtraInterface;

/**
 * ExtraTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExtraInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait ExtraTrait
{
    /**
     * {@inheritDoc}
     */
    public function before(/*# string */ $position, /*# string */ $rawString)
    {
        $clause = &$this->getClause('BEFORE');
        $pos = strtoupper($position);
        $clause[$pos][] = $rawString;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function after(/*# string */ $position, /*# string */ $rawString)
    {
        $clause = &$this->getClause('AFTER');
        $pos = strtoupper($position);
        $clause[$pos][] = $rawString;
        return $this;
    }

    /**
     * Build AFTER/BEFORE
     *
     * @param  string $beforeOrAfter BEFORE|AFTER
     * @param  string $position
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildBeforeAfter(
        /*# string */ $beforeOrAfter,
        /*# string */ $position,
        array $settings
    )/*# : string */ {
        $clause = &$this->getClause($beforeOrAfter);
        if (isset($clause[$position])) {
            $line = $clause[$position];
            $sepr = $settings['seperator'];
            return $sepr . join($sepr, $line);
        } else {
            return '';
        }
    }

    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
}
