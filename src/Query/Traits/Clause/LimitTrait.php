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

use Phossa2\Query\Interfaces\Clause\LimitInterface;

/**
 * LimitTrait
 *
 * Implementation of LimitInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     LimitInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait LimitTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function limit(/*# int */ $count, /*# int */ $offset = 0)
    {
        $clause = &$this->getClause('LIMIT');
        if ($count || $offset) {
            if (!empty($clause)) {
                $clause[0] = (int) $count;
            } else {
                $clause = [(int) $count, (int) $offset];
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offset(/*# int */ $offset)
    {
        $clause = &$this->getClause('LIMIT');
        if (!empty($clause)) {
            $clause[1] = (int) $offset;
        } else {
            $clause = [-1, (int) $offset];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30)
    {
        $clause = &$this->getClause('LIMIT');
        $clause = [(int) $perPage, ($pageNumber - 1) * $perPage];
        return $this;
    }

    /**
     * Build LIMIT
     *
     * @param  string $prefix
     * @param  settings
     * @return array
     * @access protected
     */
    protected function buildLimit(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $result = [];
        $clause = &$this->getClause('LIMIT');
        if (!empty($clause)) {
            $res = [];
            if ($clause[0]) {
                $res[] = $clause[0];
            }
            if ($clause[1]) {
                $res[] = 'OFFSET ' . $clause[1];
            }
            $result[] = join(' ', $res);
        }
        return $this->joinClause($prefix, ' ', $result, $settings);
    }
}
