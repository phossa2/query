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

namespace Phossa2\Query;

use Phossa2\Query\Misc\Raw;
use Phossa2\Query\Dialect\Mysql;
use Phossa2\Query\Misc\Expression;
use Phossa2\Shared\Base\ObjectAbstract;
use Phossa2\Query\Traits\SettingsTrait;
use Phossa2\Query\Traits\DialectAwareTrait;
use Phossa2\Query\Traits\ParameterAwareTrait;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\DialectInterface;
use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * Builder
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     BuilderInterface
 * @see     StatementInterface
 * @see     SelectStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Builder extends ObjectAbstract implements BuilderInterface
{
    use DialectAwareTrait, SettingsTrait, ParameterAwareTrait;

    /**
     * tables
     *
     * @var    array
     * @access protected
     */
    protected $tables = [];

    /**
     * Constructor
     *
     * ```php
     * // builder with default table `users` and Mysql dialect
     * $users = new Builder('users', new Mysql())
     *
     * // builder with defult tables:  `users` and `accounts` AS `a`
     * $builder = new Builder(['users', 'accounts' => 'a'])
     *
     * // change default settings
     * $builder = new Builder('users', new Mysql(), ['autoQuote' => false]);
     * ```
     *
     * @param  string|array $table table[s] to build upon
     * @param  DialectInterface $dialect default dialect is `Mysql`
     * @param  array $settings builder settings
     * @access public
     */
    public function __construct(
        $table = '',
        DialectInterface $dialect = null,
        array $settings = []
    ) {
        $this
            ->initParameter()
            ->setSettings(array_replace($this->defaultSettings(), $settings))
            ->setDialect($dialect)
            ->table($table);
    }

    /**
     * Change table[s]
     *
     * @param  $table change to table[s]
     * @return $this
     * @access public
     */
    public function __invoke($table)
    {
        return $this->table($table);
    }

    /**
     * {@inheritDoc}
     */
    public function expr()/*# : ExpressionInterface */
    {
        return new Expression($this);
    }

    /**
     * {@inheritDoc}
     */
    public function raw(/*# string */ $string)/*# : OutputInterface */
    {
        // values found
        if (func_num_args() > 1) {
            $values = func_get_arg(1);
            $string = $this->getParameter()
                ->replaceQuestionMark($string, $values);
        }
        return new Raw($string);
    }

    /**
     * If has existing tables, return a new instance with provided table[s]
     *
     * {@inheritDoc}
     */
    public function table($table, /*# string */ $alias = '')
    {
        $tbl = $this->fixTable($table, $alias);
        $clone = [] === $this->tables ? $this : clone $this;
        $clone->tables = $tbl;
        return $clone;
    }

    /**
     * Append to existing tables
     *
     * {@inheritDoc}
     */
    public function from($table, /*# string */ $alias = '')
    {
        $tbl = $this->fixTable($table, $alias);
        $this->tables = array_merge($this->tables, $tbl);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function select(
        $col = '',
        /*# string */ $alias = ''
    )/*# : SelectStatementInterface */ {
        /* @var SelectStatementInterface $select */
        $select = $this->getDialect()->select($this);
        return $select->table($this->tables)->col($col, $alias);
    }

    /**
     * Convert to [$table => alias] or [$table]
     *
     * @param  string|string[] $table
     * @param  string $alias
     * @return array
     * @access protected
     */
    protected function fixTable(
        $table,
        /*# string */ $alias = ''
    )/*# : array */ {
        if (empty($table)) {
            $table = [];
        } elseif (!is_array($table)) {
            $table = empty($alias) ? [$table] : [$table => $alias];
        }
        return $table;
    }

    /**
     * Builder default settings
     *
     * @return array
     * @access protected
     */
    protected function defaultSettings()/*# : array */
    {
        return [
            'autoQuote' => true,
            'positionedParam' => false,
            'namedParam' => false,
            'seperator' => ' ',
            'indent' => '',
            'escapeFunction' => null,
            'useNullAsDefault' => false,
        ];
    }
}
