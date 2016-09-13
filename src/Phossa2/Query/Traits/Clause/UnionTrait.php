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

use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Interfaces\Clause\UnionInterface;

/**
 * UnionTrait
 *
 * Implementation of UnionInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UnionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait UnionTrait
{
    /**
     * {@inheritDoc}
     */
    public function union()/*# : BuilderInterace */
    {
        $clause = &$this->getClause('UNION');
        $clause[] = 'UNION';
        return $this->getBuilder()->setPrevious($this);
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : BuilderInterace */
    {
        $clause = &$this->getClause('UNION');
        $clause[] = 'UNION ALL';
        return $this->getBuilder()->setPrevious($this);
    }

    /**
     * Build UNION/UNION ALL
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildUnion(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $clause = &$this->getClause('UNION');
        if (!empty($clause)) {
            return $settings['seperator'] . $clause[0];
        } else {
            return $prefix;
        }
    }

    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract public function setPrevious(StatementInterface $previous = null);
    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    abstract public function getBuilder()/*# : BuilderInterface */;
}
