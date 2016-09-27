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

use Phossa2\Query\Traits\Clause\OnTrait;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Traits\Clause\WhereTrait;
use Phossa2\Query\Traits\Clause\ClauseTrait;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\ExpressionInterface;

/**
 * Expression
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExpressionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Expression extends StatementAbstract implements ExpressionInterface
{
    use ClauseTrait, WhereTrait, OnTrait;

    /**
     * {@inheritDoc}
     */
    public function __construct(BuilderInterface $builder)
    {
        parent::__construct($builder);

        // force flat notation
        $this->setSettings(['seperator' => ' ', 'indent' => '']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getConfigs()/*# : array */
    {
        return ['WHERE' => '', 'ON' => ''];
    }

    /**
     * {@inheritDoc}
     */
    protected function getType()/*# : string */
    {
        return '';
    }
}
