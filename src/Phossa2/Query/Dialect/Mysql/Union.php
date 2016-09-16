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

namespace Phossa2\Query\Dialect\Mysql;

use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\LimitTrait;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Traits\Clause\OrderByTrait;
use Phossa2\Query\Interfaces\Statement\UnionStatementInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * Union
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     UnionStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Union extends StatementAbstract implements UnionStatementInterface
{
    use ClauseTrait, OrderByTrait, LimitTrait;

    /**
     * {@inheritDoc}
     */
    protected $configs = [
        'UNION' => '',
        'ORDERBY' => 'ORDER BY',
        'LIMIT' => 'LIMIT',
    ];

    /**
     * {@inheritDoc}
     */
    public function union(SelectStatementInterface $select)
    {
        return $this->addUnion('UNION', $select);
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll(SelectStatementInterface $select)
    {
        return $this->addUnion('UNION ALL', $select);
    }

    /**
     * Build unioned SELECT
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
        $flat = $this->flatSettings($settings);

        $parts = [];
        foreach ($clause as $idx => $field) {
            if ($idx) { // prepend type UNION or UNION ALL
                $parts[] = $field[1];
            }
            $parts[] = $this->quoteItem($field[0], $flat);
        }
        return trim($this->joinClause($prefix, '', $parts, $settings));
    }

    /**
     * @param  string $type
     * @param  SelectStatementInterface $select
     * @return $this
     * @access protected
     */
    protected function addUnion(
        /*# string */ $type,
        SelectStatementInterface $select
    ) {
        $clause = &$this->getClause('UNION');
        $clause[] = [$select, $type];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return '';
    }
}
