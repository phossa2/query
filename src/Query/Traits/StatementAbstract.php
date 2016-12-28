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

namespace Phossa2\Query\Traits;

use Phossa2\Shared\Base\ObjectAbstract;
use Phossa2\Query\Traits\Clause\ExtraClauseTrait;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\StatementInterface;

/**
 * StatementAbstract
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     StatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
abstract class StatementAbstract extends ObjectAbstract implements StatementInterface
{
    use SettingsAwareTrait, BuilderAwareTrait, ExtraClauseTrait, PreviousTrait;

    /**
     * value bindings
     *
     * @var    array
     * @access protected
     */
    protected $bindings;

    /**
     * clause configs,[name => prefix]
     *
     * @var    array
     * @access protected
     */
    protected $configs = [];

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(array $settings = [])/*# : string */
    {
        // combine settings
        $settings = $this->combineSettings($settings);

        // build current sql
        $sql = $this->buildSql($settings);

        // replace with ?, :name or real values
        return $this->bindValues($sql, $settings);
    }

    /**
     * {@inheritDoc}
     */
    public function getNamedStatement(array $settings = [])/*# : string */
    {
        $settings['positionedParam'] = false;
        $settings['namedParam'] = true;
        return $this->getStatement($settings);
    }

    /**
     * Return the sql string (with parameter replaced)
     *
     * @param  array $settings extra settings if any
     * @return string
     * @access public
     * @api
     */
    public function getSql(array $settings = [])/*# : string */
    {
        $settings['positionedParam'] = false;
        $settings['namedParam'] = false;
        return $this->getStatement($settings);
    }

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */
    {
        return $this->bindings;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getSql();
    }

    /**
     * Combine builder/statement and provided settings
     *
     * @param  array $settings statement specific settings
     * @return array
     * @access protected
     */
    protected function combineSettings(array $settings)/*# : array */
    {
        return array_replace(
            $this->getBuilder()->getSettings(), // builder settings
            $this->getBuilder()->getDialect()->dialectSettings(), // dialect
            $settings,  // user settings
            $this->getSettings() // statement settings
        );
    }

    /**
     * Build SQL statement clauses
     *
     * @param  array $settings
     * @param  string
     * @access protected
     */
    protected function buildSql(array $settings)/*# : string */
    {
        $result = $this->getType(); // type
        $settings['join'] = $settings['seperator'] . $settings['indent'];

        $result .= $this->buildBeforeAfter('AFTER', 'TYPE', $settings); // hint
        foreach ($this->getConfigs() as $pos => $prefix) {
            // before
            $result .= $this->buildBeforeAfter('BEFORE', $pos, $settings);

            $method = 'build' . ucfirst(strtolower($pos));
            $result .= $this->{$method}($prefix, $settings);

            // after
            $result .= $this->buildBeforeAfter('AFTER', $pos, $settings);
        }

        $result .= $this->buildBeforeAfter('AFTER', 'STMT', $settings);
        return $result;
    }

    /**
     * Replace placeholders in the sql with '?', ':named' or real value
     *
     * @param  string $sql
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function bindValues(/*# string */ $sql, array $settings)/*# : string */
    {
        // init bindings
        $this->bindings = [];

        // bind values
        return $this->getBuilder()->getParameter()
            ->bindValues($sql, $this->bindings, $settings);
    }

    /**
     * Clause configs ['name' => 'prefix']
     *
     * @return array
     * @access protected
     */
    abstract protected function getConfigs()/*# : array */;

    /**
     * Get current statement type. e.g. 'SELECT' etc.
     *
     * @return string
     * @access protected
     */
    abstract protected function getType()/*# : string */;
}
