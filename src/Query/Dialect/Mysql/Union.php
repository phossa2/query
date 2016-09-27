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
use Phossa2\Query\Traits\Clause\OrderTrait;
use Phossa2\Query\Interfaces\Statement\UnionStatementInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;
use Phossa2\Query\Interfaces\BuilderInterface;

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
    use ClauseTrait, OrderTrait, LimitTrait;

    /**
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        parent::__construct($builder);
    }

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

        $res = '';
        foreach ($clause as $idx => $field) {
            $parts = [];
            $prefix = $idx ? $field[1] : '';
            $parts[] = $this->quoteItem($field[0], $flat);
            $res .= $this->joinClause($prefix, '', $parts, $settings);
        }
        return ltrim($res);
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
    protected function getConfigs()/*# : array */
    {
        return [
            'UNION' => '',
            'ORDER' => 'ORDER BY',
            'LIMIT' => 'LIMIT',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return '';
    }
}
