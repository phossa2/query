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
    use AbstractTrait;

    /**
     * 0 NO, 1 YES, 2 UNION ALL
     * @var    int
     * @access protected
     */
    protected $is_union = UnionInterface::UNION_NOT;

    /**
     * {@inheritDoc}
     */
    public function union()/*# : SelectStatementInterface */
    {
        $this->is_union = UnionInterface::UNION_YES;
        return $this->getBuilder()->select()->table('')->setPrevious($this);
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : SelectStatementInterface */
    {
        $this->is_union = UnionInterface::UNION_ALL;
        return $this->getBuilder()->select()->table('')->setPrevious($this);
    }

    /**
     * Override `getStatement()` in StatementAbstract
     *
     * {@inheritDoc}
     */
    public function getStatement(array $settings = [])/*# : string */
    {
        // combine settings
        $settings = $this->combineSettings($settings);

        // statements
        $sql = [];

        // build previous statement
        if ($this->hasPrevious()) {
            $sql[] = $this->getPrevious()->getStatement($settings);
        }

        // build current sql
        $sql[] = $this->buildSql($settings);

        // replace with ?, :name or real values
        return $this->bindValues(join($settings['seperator'], $sql), $settings);
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
        switch ($this->is_union) {
            case UnionInterface::UNION_YES:
                return $settings['seperator'] . 'UNION';
            case UnionInterface::UNION_ALL:
                return $settings['seperator'] . 'UNION ALL';
            default:
                return $prefix;
        }
    }
}
