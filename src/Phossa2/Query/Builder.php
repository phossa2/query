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

use Phossa2\Query\Dialect\Mysql;
use Phossa2\Query\Message\Message;
use Phossa2\Shared\Base\ObjectAbstract;
use Phossa2\Query\Traits\SettingsTrait;
use Phossa2\Query\Traits\DialectAwareTrait;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\DialectInterface;
use Phossa2\Query\Interfaces\StatementInterface;
use Phossa2\Query\Exception\BadMethodCallException;

/**
 * Builder
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     BuilderInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Builder extends ObjectAbstract implements BuilderInterface
{
    use DialectAwareTrait, SettingsTrait;

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
        // settings
        $this->setSettings($settings);

        // @TODO default to Mysql
        $this->setDialect($dialect ?: new Mysql());

        // tables
        $this->from($table);
    }

    /**
     * {@inheritDoc}
     */
    public function expr()/*# : ExpressionInterface */
    {
        // @TODO
    }

    /**
     * {@inheritDoc}
     */
    public function raw(/*# string */ $string)/*# : RawInterface */
    {
        // @TODO
    }

    /**
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
        /* @var $select SelectStatementInterface */
        $select = $this->getDialectStatement('select');
        return $select->table($this->tables)->col($col, $alias);
    }

    /**
     * fix table notation
     *
     * Convert to [$table => alias] or [$table]
     *
     * @param  mixed $table
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
     * Get the statement object
     *
     * @param  string $method
     * @return StatementInterface
     * @throws BadMethodCallException if no method found for this dialect
     * @access protected
     */
    protected function getDialectStatement(
        /*# string */ $method
    )/*# StatementInterface */ {
        $dialect = $this->getDialect();
        if (!method_exists($dialect, $method)) {
            throw new BadMethodCallException(
                Message::get(
                    Message::MSG_METHOD_NOTFOUND,
                    $method,
                    get_class($dialect)
                ),
                Message::MSG_METHOD_NOTFOUND
            );
        }

        /* @var $statement StatementInterface */
        $statement = call_user_func([$dialect, $method], $this);

        return $statement;
    }
}
