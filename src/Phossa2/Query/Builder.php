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
use Phossa2\Query\Traits\SettingsAwareTrait;
use Phossa2\Query\Traits\DialectAwareTrait;
use Phossa2\Query\Traits\ParameterAwareTrait;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\DialectInterface;
use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Interfaces\Clause\ColInterface;
use Phossa2\Query\Interfaces\Statement\UnionStatementInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;
use Phossa2\Query\Interfaces\Statement\InsertStatementInterface;
use Phossa2\Query\Interfaces\Statement\UpdateStatementInterface;
use Phossa2\Query\Interfaces\Statement\DeleteStatementInterface;

/**
 * Builder
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     BuilderInterface
 * @see     StatementInterface
 * @see     SelectStatementInterface
 * @see     InsertStatementInterface
 * @see     UnionStatementInterface
 * @see     UpdateStatementInterface
 * @see     DeleteStatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Builder extends ObjectAbstract implements BuilderInterface
{
    use DialectAwareTrait, SettingsAwareTrait, ParameterAwareTrait;

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
    public function raw(
        /*# string */ $string,
        array $values = []
    )/*# : OutputInterface */ {
        if (!empty($values)) {
            $string = $this->getParameter()->replaceQuestionMark($string, $values);
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
    public function select()/*# : SelectStatementInterface */
    {
        /* @var SelectStatementInterface $select */
        $select = $this->getDialect()->select($this);
        return $select->table($this->tables)->col(func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function insert(array $values = [])/*# : InsertStatementInterface */
    {
        /* @var InsertStatementInterface $insert */
        $insert = $this->getDialect()->insert($this);
        return $insert->into(current($this->tables))->set($values);
    }

    /**
     * {@inheritDoc}
     */
    public function replace(array $values = [])/*# : InsertStatementInterface */
    {
        /* @var InsertStatementInterface $insert */
        $replace = $this->getDialect()->replace($this);
        return $replace->into(current($this->tables))->set($values);
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $values = [])/*# : UpdateStatementInterface */
    {
        /* @var UpdateStatementInterface $update */
        $update = $this->getDialect()->update($this);
        return $update->from(current($this->tables))->set($values);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()/*# : DeleteStatementInterface */
    {
        /* @var DeleteStatementInterface $delete */
        $delete = $this->getDialect()->delete($this)->from(current($this->tables));

        if ($delete instanceof ColInterface) { // multiple table deletion
            $delete->col(func_get_args());
        }
        return $delete;
    }

    /**
     * {@inheritDoc}
     */
    public function union()/*# : UnionStatementInterface */
    {
        /* @var UnionStatementInterface $union */
        $union = $this->getDialect()->union($this);
        if (func_num_args() > 0) { // acception variable parameters
            $args = func_get_args();
            foreach ($args as $arg) {
                $union->union($arg);
            }
        }
        return $union;
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
            'positionedParam' => true,
            'namedParam' => false,
            'seperator' => ' ',
            'indent' => '',
            'escapeFunction' => null,
            'useNullAsDefault' => false,
        ];
    }
}
