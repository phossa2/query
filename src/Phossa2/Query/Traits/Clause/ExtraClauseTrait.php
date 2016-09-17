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

use Phossa2\Query\Interfaces\Clause\ExtraClauseInterface;

/**
 * ExtraClauseTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExtraClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait ExtraClauseTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function before(/*# string */ $position, /*# string */ $rawString)
    {
        $rawString = $this->positionedParam($rawString, func_get_args(), 2);
        return $this->beforeAfter('BEFORE', $position, $rawString);
    }

    /**
     * {@inheritDoc}
     */
    public function after(/*# string */ $position, /*# string */ $rawString)
    {
        $rawString = $this->positionedParam($rawString, func_get_args(), 2);
        return $this->beforeAfter('AFTER', $position, $rawString);
    }

    /**
     * {@inheritDoc}
     */
    public function hint(/*# string */ $hintString)
    {
        return $this->beforeAfter('AFTER', 'TYPE', $hintString);
    }

    /**
     * {@inheritDoc}
     */
    public function option(/*# string */ $optionString)
    {
        return $this->beforeAfter('AFTER', 'STMT', $optionString);
    }

    /**
     * @param  string $type
     * @param  string $position
     * @param  string $rawString
     * @return $this
     * @access protected
     */
    protected function beforeAfter(
        /*# string */ $type,
        /*# string */ $position,
        /*# string */ $rawString
    ) {
        $clause = &$this->getClause($type);
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
}
